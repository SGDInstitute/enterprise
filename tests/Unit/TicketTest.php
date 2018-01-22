<?php

namespace Tests\Unit;

use App\Event;
use App\Ticket;
use App\TicketType;
use App\User;
use App\Profile;
use App\Order;
use App\Mail\InviteUserEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_tickets_that_are_filled_out()
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
        $order = $event->orderTickets(factory(User::class)->create(), [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $this->assertEquals(0, $order->tickets()->filled()->count());
    }

    /** @test */
    public function can_get_tickets_that_are_complete()
    {
        $profileA = factory(Profile::class)->create(['tshirt' => 'L']);
        $profileB = factory(Profile::class)->create(['tshirt' => 'S']);
        $profileC = factory(Profile::class)->create(['tshirt' => null]);

        $order = factory(Order::class)->create();

        $order->tickets()->saveMany([
            factory(Ticket::class)->make(['user_id' => $profileA->user_id]),
            factory(Ticket::class)->make(['user_id' => $profileB->user_id]),
            factory(Ticket::class)->make(['user_id' => $profileC->user_id]),
        ]);

        $this->assertEquals(2, $order->tickets()->completed()->count());
        $this->assertContains($profileA->user_id, $order->tickets()->completed()->get()->pluck('user_id'));
        $this->assertContains($profileB->user_id, $order->tickets()->completed()->get()->pluck('user_id'));
    }

    /** @test */
    public function tickets_are_completed_when_name_email_and_thshirt_are_not_null()
    {
        $ticket = factory(Ticket::class)->create(['user_id' => null]);

        $this->assertFalse($ticket->isComplete());

        $user = factory(User::class)->create(['name' => 'Jane Doe', 'email' => 'jdoe@example.com']);
        $ticket->user_id = $user->id;
        $ticket->save();

        $this->assertFalse($ticket->fresh()->isComplete());
        $this->assertTrue($ticket->fresh()->isFilled());

        $user->profile->tshirt = 'M';
        $user->profile->save();

        $this->assertTrue($ticket->fresh()->isComplete());
    }

    /** @test */
    public function hash_is_added_when_creating()
    {
        $ticket = factory(Ticket::class)->create();

        $this->assertGreaterThanOrEqual(5, strlen($ticket->fresh()->hash));
    }

    /** @test */
    public function can_invite_user()
    {
        Mail::fake();

        $ticket = factory(Ticket::class)->create(['user_id' => null]);

        $ticket->invite('hpotter@hogwarts.edu', 'Hello world!');

        $ticket->fresh();
        $this->assertNotNull($ticket->user_id);

        Mail::assertSent(InviteUserEmail::class, function ($mail) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->note === 'Hello world!';
        });
    }

    /** @test */
    public function can_fill_ticket()
    {
        $ticket = factory(Ticket::class)->create(['user_id' => null]);

        $ticket->fillManually([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'L',
            'accommodation' => 'My scar hurts sometimes'
        ]);

        $ticket->fresh();
        $this->assertNotNull($ticket->user_id);
        $this->assertEquals('Harry Potter', $ticket->user->name);
        $this->assertEquals('hpotter@hogwarts.edu', $ticket->user->email);
        $this->assertEquals('he, him, his', $ticket->user->profile->pronouns);
        $this->assertEquals('Straight', $ticket->user->profile->sexuality);
        $this->assertEquals('Male', $ticket->user->profile->gender);
        $this->assertEquals('White', $ticket->user->profile->race);
        $this->assertEquals('Hogwarts', $ticket->user->profile->college);
        $this->assertEquals('L', $ticket->user->profile->tshirt);
        $this->assertEquals('My scar hurts sometimes', $ticket->user->profile->accommodation);
        $this->assertEquals('manual', $ticket->type);
    }

    /** @test */
    public function filling_ticket_sends_email_if_specified()
    {
        Mail::fake();

        $ticket = factory(Ticket::class)->create(['user_id' => null]);

        $ticket->fillManually([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'L',
            'accommodation' => 'My scar hurts sometimes',
            'send_email' => true,
            'message' => 'Hello world!',
        ]);

        $ticket->fresh();
        $this->assertNotNull($ticket->user_id);
        $this->assertEquals('Harry Potter', $ticket->user->name);
        $this->assertEquals('hpotter@hogwarts.edu', $ticket->user->email);
        $this->assertEquals('he, him, his', $ticket->user->profile->pronouns);
        $this->assertEquals('Straight', $ticket->user->profile->sexuality);
        $this->assertEquals('Male', $ticket->user->profile->gender);
        $this->assertEquals('White', $ticket->user->profile->race);
        $this->assertEquals('Hogwarts', $ticket->user->profile->college);
        $this->assertEquals('L', $ticket->user->profile->tshirt);
        $this->assertEquals('My scar hurts sometimes', $ticket->user->profile->accommodation);

        Mail::assertSent(InviteUserEmail::class, function ($mail) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->note === 'Hello world!';
        });
    }

    /** @test */
    public function can_find_by_hash()
    {
        $ticket = factory(Ticket::class)->create();

        $foundTicket = Ticket::findByHash($ticket->hash);

        $this->assertEquals($ticket->id, $foundTicket->id);
    }
}
