<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\TicketType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function invoice_pdf_has_user_address()
    {
        $order = Order::factory()->create();
        $invoice = $order->invoice()->save(Invoice::factory()->make([
            'address' => '123 Main',
            'address_2' => 'Suite 2',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip' => '60660',
        ]));

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertStringContainsString('123 Main', $view);
        $this->assertStringContainsString('Suite 2', $view);
        $this->assertStringContainsString('Chicago', $view);
        $this->assertStringContainsString('IL', $view);
        $this->assertStringContainsString('60660', $view);
    }

    /** @test */
    public function invoice_pdf_has_amount()
    {
        $event = Event::factory()->published()->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertStringContainsString('$100.00', $view);
    }

    /** @test */
    public function invoice_pdf_has_ticket_types_and_quantities()
    {
        $event = Event::factory()->published()->create();
        $ticketType1 = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $ticketType2 = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Pro Ticket',
        ]));
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
            ['ticket_type_id' => $ticketType2->id, 'quantity' => 3],
        ]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertStringContainsString('Regular Ticket', $view);
        $this->assertStringContainsString('<td>2</td>', $view);
        $this->assertStringContainsString('Pro Ticket', $view);
        $this->assertStringContainsString('<td>3</td>', $view);
    }

    /** @test */
    public function invoice_pdf_has_mailto_address_for_event()
    {
        $event = Event::factory()->published()->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $ticketType2 = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Pro Ticket',
        ]));
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
            ['ticket_type_id' => $ticketType2->id, 'quantity' => 3],
        ]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertStringContainsString(config('institute.address'), $view);
    }

    /** @test */
    public function invoice_pdf_has_due_date()
    {
        $event = Event::factory()->published()->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertStringContainsString('Due Date', $view);
        $this->assertStringContainsString(Carbon::now()->addDays(60)->toFormattedDateString(), $view);
    }

    /** @test */
    public function can_get_due_date_attribute()
    {
        $event = Event::factory()->create(['start' => Carbon::parse('+120 days')]);
        $order = Order::factory()->create(['event_id' => $event->id]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $this->assertEquals(Carbon::parse('+60 days')->toFormattedDateString(), $invoice->due_date->toFormattedDateString());

        $event = Event::factory()->create(['start' => Carbon::parse('+30 days')]);
        $order = Order::factory()->create(['event_id' => $event->id]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $this->assertEquals(Carbon::parse('+30 days')->toFormattedDateString(), $invoice->due_date->toFormattedDateString());
    }
}
