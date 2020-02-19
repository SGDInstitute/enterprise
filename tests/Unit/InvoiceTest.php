<?php

namespace Tests\Unit;

use App\Event;
use App\Invoice;
use App\Order;
use App\TicketType;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function invoice_pdf_has_user_address()
    {
        $order = factory(Order::class)->create();
        $invoice = $order->invoice()->save(factory(Invoice::class)->make([
            'address' => '123 Main',
            'address_2' => 'Suite 2',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip' => '60660',
        ]));

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertContains('123 Main', $view);
        $this->assertContains('Suite 2', $view);
        $this->assertContains('Chicago', $view);
        $this->assertContains('IL', $view);
        $this->assertContains('60660', $view);
    }

    /** @test */
    public function invoice_pdf_has_amount()
    {
        $event = factory(Event::class)->states('published')->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertContains('$100.00', $view);
    }

    /** @test */
    public function invoice_pdf_has_ticket_types_and_quantities()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $ticketType2 = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Pro Ticket',
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
            ['ticket_type_id' => $ticketType2->id, 'quantity' => 3],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertContains('Regular Ticket', $view);
        $this->assertContains('<td>2</td>', $view);
        $this->assertContains('Pro Ticket', $view);
        $this->assertContains('<td>3</td>', $view);
    }

    /** @test */
    public function invoice_pdf_has_mailto_address_for_event()
    {
        $event = factory(Event::class)->states('published')->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $ticketType2 = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Pro Ticket',
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
            ['ticket_type_id' => $ticketType2->id, 'quantity' => 3],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertContains(config('institute.address'), $view);
    }

    /** @test */
    public function invoice_pdf_has_due_date()
    {
        $event = factory(Event::class)->states('published')->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $view = view('pdf.invoice', compact('order'))->render();

        $this->assertContains('Due Date', $view);
        $this->assertContains(Carbon::now()->addDays(60)->toFormattedDateString(), $view);
    }

    /** @test */
    public function can_get_due_date_attribute()
    {
        $event = factory(Event::class)->create(['start' => Carbon::parse('+120 days')]);
        $order = factory(Order::class)->create(['event_id' => $event->id]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $this->assertEquals(Carbon::parse('+60 days')->toFormattedDateString(), $invoice->due_date->toFormattedDateString());

        $event = factory(Event::class)->create(['start' => Carbon::parse('+30 days')]);
        $order = factory(Order::class)->create(['event_id' => $event->id]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $this->assertEquals(Carbon::parse('+30 days')->toFormattedDateString(), $invoice->due_date->toFormattedDateString());
    }
}
