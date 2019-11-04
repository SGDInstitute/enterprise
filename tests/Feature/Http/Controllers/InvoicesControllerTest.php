<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use App\Invoice;
use App\Mail\InvoiceEmail;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InvoicesController
 */
class InvoicesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_invoice()
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

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertSee('Invoice');
    }

    /** @test */
    public function customer_can_edit_invoice()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jdoe@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make([
            'name' => 'Phoenix Johnson',
            'email' => 'pjohnson@example.com',
            'address' => '123 Main',
            'address_2' => 'Suite 123',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip' => '60660',
        ]));

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->json('patch', "/invoices/{$invoice->id}", [
                'name' => 'Jo Johnson',
                'email' => 'jo@example.com',
                'address' => '1234 Main',
                'address_2' => 'Suite 1234',
                'city' => 'Downers Grove',
                'state' => 'IL',
                'zip' => '60516',
            ]);

        $response->assertStatus(200);
        $this->assertEquals('Jo Johnson', $order->invoice->name);
        $this->assertEquals('jo@example.com', $order->invoice->email);
        $this->assertEquals('1234 Main', $order->invoice->address);
        $this->assertEquals('Suite 1234', $order->invoice->address_2);
        $this->assertEquals('Downers Grove', $order->invoice->city);
        $this->assertEquals('IL', $order->invoice->state);
        $this->assertEquals('60516', $order->invoice->zip);

        Mail::assertSent(InvoiceEmail::class, function ($mail) use ($invoice) {
            return $mail->hasTo('jdoe@example.com')
                && $mail->hasCc('jo@example.com');
        });
    }

    /** @test */
    public function cannot_edit_invoice_without_name()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $response = $this
            ->actingAs($user)
            ->json('PATCH', "/invoices/{$invoice->id}", [
                'email' => 'pjohnson@hogwarts.edu',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => '60660',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors(['name']);
    }

    /** @test */
    public function cannot_edit_invoice_without_email()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $response = $this
            ->actingAs($user)
            ->json('PATCH', "/invoices/{$invoice->id}", [
                'name' => 'Jo Johnson',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => '60660',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors(['email']);
    }

    /** @test */
    public function cannot_create_invoice_without_valid_zip()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $response = $this
            ->actingAs($user)
            ->json('PATCH', "/invoices/{$invoice->id}", [
                'name' => 'Jo Johnson',
                'email' => 'pjohnson@hogwarts.edu',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => 'abcdef',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors(['zip']);
    }

    /** @test */
    public function can_remove_address_from_invoice()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make([
            'address' => '123 Main',
            'address_2' => 'Suite 123',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip' => '60660',
        ]));

        $response = $this
            ->actingAs($user)
            ->json('PATCH', "/invoices/{$invoice->id}", [
                'name' => 'Jo Johnson',
                'email' => 'pjohnson@hogwarts.edu',
                'address' => '',
                'address_2' => '',
                'city' => '',
                'state' => '',
                'zip' => '',
            ]);

        $response->assertStatus(200);

        $invoice->refresh();
        $this->assertNull($invoice->address);
        $this->assertNull($invoice->address_2);
        $this->assertNull($invoice->city);
        $this->assertNull($invoice->state);
        $this->assertNull($invoice->zip);
    }
}
