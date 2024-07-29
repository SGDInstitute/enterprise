<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Price as StripePrice;
use Stripe\Product as StripeProduct;

class TicketType extends Model
{
    use HasFactory;

    public $guarded = [];

    protected function casts(): array
    {
        return [
            'end' => 'datetime',
            'form' => 'collection',
            'start' => 'datetime',
        ];
    }

    public static function createFlatWithStripe($data, $cost)
    {
        $data = array_merge(['structure' => 'flat'], $data);
        $stripeProduct = StripeProduct::create(['name' => $data['name']]);

        $ticket = self::create(array_merge(['stripe_product_id' => $stripeProduct->id], $data));

        $stripePrice = StripePrice::create([
            'unit_amount' => $cost,
            'currency' => 'usd',
            'product' => $stripeProduct->id,
        ]);

        $ticket->prices()->create([
            'name' => $data['name'],
            'cost' => $cost,
            'stripe_price_id' => $stripePrice->id,
            'timezone' => $data['timezone'],
            'start' => $data['start'],
            'end' => $data['end'],
        ]);

        return $ticket;
    }
    // Relationships

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    // Attributes

    public function getAvailablityAttribute()
    {
        if ($this->start && $this->end) {
            return 'Available: ' . $this->start->timezone($this->timezone)->format('M j') . ' - ' . $this->end->timezone($this->timezone)->format('M j, Y');
        }
    }

    public function getFormattedEndAttribute()
    {
        return $this->end?->timezone($this->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getFormattedStartAttribute()
    {
        return $this->start->timezone($this->timezone)->format('m/d/Y g:i A') ?? null;
    }

    public function getPriceRangeAttribute()
    {
        if ($this->prices->count() > 1) {
            return '$' . $this->prices->min('cost') / 100 . ' - $' . $this->prices->max('cost') / 100;
        }

        return '$' . $this->prices->min('cost') / 100;
    }

    // Methods

    public function safeDelete()
    {
        $this->prices->each(fn ($price) => $price->delete());
        $this->delete();
    }
}
