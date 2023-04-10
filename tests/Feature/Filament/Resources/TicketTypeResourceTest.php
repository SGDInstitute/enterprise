<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\TicketTypeResource\Pages\CreateTicketType;
use App\Filament\Resources\TicketTypeResource\Pages\EditTicketType;
use App\Models\Event;
use App\Models\Price;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class TicketTypeResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_ticket_type()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        Livewire::test(CreateTicketType::class)
            ->fillForm([
                'event_id' => $event->id,
                'structure' => 'flat',
                'name' => 'TEST: Regular Registration',
                'description' => 'Comes with lunch',
                'start' => now(),
                'end' => now()->addMonths(6),
                'timezone' => 'America/Chicago',
                'cost' => '10.00',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $ticketType = $event->fresh()->ticketTypes->where('name', 'TEST: Regular Registration')->first();
        $this->assertNotNull($ticketType);
        $this->assertCount(1, $prices = $ticketType->prices);
        $this->assertEquals(1000, $prices->first()->cost);
        $this->assertNotNull($prices->first()->stripe_price_id);
    }

    /** @test */
    public function can_edit_ticket_type()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create([
            'name' => 'Regular Registration',
            'structure' => 'flat',
            'start' => Carbon::parse('2023-04-10'),
            'end' => Carbon::parse('2023-10-06'),
        ]);
        $price = Price::factory()->for($ticketType)->create(['name' => 'Regular Registration', 'cost' => 10000]);
        $newStart = Carbon::parse('2023-10-06', $ticketType->timezone);
        $newEnd = Carbon::parse('2023-11-05', $ticketType->timezone);

        Livewire::test(EditTicketType::class, ['record' => $ticketType->id])
            ->assertFormSet([
                'cost' => '100.00',
            ])
            ->fillForm([
                'name' => 'Late Registration',
                'description' => 'For late comers',
                'start' => $newStart->toDateTimeString(),
                'end' => $newEnd->toDateTimeString(),
                'cost' => '115.00',
            ])
            ->call('save');

        $ticketType->refresh();
        $this->assertEquals('Late Registration', $ticketType->name);
        $this->assertEquals('For late comers', $ticketType->description);
        $this->assertEquals($newStart->timezone('UTC'), $ticketType->start);
        $this->assertEquals($newEnd->timezone('UTC'), $ticketType->end);
        $this->assertEquals('11500', $price->fresh()->cost);
    }
}
