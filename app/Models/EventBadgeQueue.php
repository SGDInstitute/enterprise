<?php

namespace App\Models;

use App\Notifications\BadgePrinted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBadgeQueue extends Model
{
    use HasFactory;

    public $guarded = [];

    public $table = 'event_badge_queue';

    // Relations

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attributes

    // Methods

    public function markAsPrinted()
    {
        $this->printed = true;
        $this->save();

        $this->user->notify(new BadgePrinted($this));
    }
}
