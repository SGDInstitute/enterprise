<?php

namespace Tests\Feature;

use App\Event;
use App\Mail\InvoiceEmail;
use App\TicketType;
use App\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceForOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_create_invoice()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->json('POST', "/orders/{$order->id}/invoices", [
                'name' => 'Phoenix Johnson',
                'email' => 'pjohnson@hogwarts.edu',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => '60660'
            ]);

        $response->assertStatus(201);

        $order->refresh();
        $this->assertNotNull($order->invoice);
        $this->assertEquals('Phoenix Johnson', $order->invoice->name);
        $this->assertEquals('pjohnson@hogwarts.edu', $order->invoice->email);
        $this->assertEquals('123 Main', $order->invoice->address);
        $this->assertEquals('Suite 123', $order->invoice->address_2);
        $this->assertEquals('Chicago', $order->invoice->city);
        $this->assertEquals('IL', $order->invoice->state);
        $this->assertEquals('60660', $order->invoice->zip);

        Mail::assertSent(InvoiceEmail::class, function ($mail) use ($order) {
            return $mail->hasTo('jo@example.com')
                && $mail->order->id === $order->id
                && $mail->order->invoice->id = $order->invoice->id;
        });
    }

    /** @test */
    public function cannot_create_invoice_without_name()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this
            ->actingAs($user)
            ->json('POST', "/orders/{$order->id}/invoices", [
                'email' => 'pjohnson@hogwarts.edu',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => '60660'
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors(['name']);
    }

    /** @test */
    public function cannot_create_invoice_without_email()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this
            ->actingAs($user)
            ->json('POST', "/orders/{$order->id}/invoices", [
                'name' => 'Jo Johnson',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => '60660'
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
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this
            ->actingAs($user)
            ->json('POST', "/orders/{$order->id}/invoices", [
                'name' => 'Jo Johnson',
                'email' => 'pjohnson@hogwarts.edu',
                'address' => '123 Main',
                'address_2' => 'Suite 123',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip' => 'abcdef'
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors(['zip']);
    }

    /** @test */
    public function can_create_invoice_without_address()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $response = $this
            ->withoutExceptionHandling()
            ->actingAs($user)
            ->json('POST', "/orders/{$order->id}/invoices", [
                'name' => 'Phoenix Johnson',
                'email' => 'pjohnson@hogwarts.edu',
            ]);

        $response->assertStatus(201);
    }
}
