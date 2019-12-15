<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use App\Order;
use App\Ticket;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TicketsController
 */
class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_user_to_ticket()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/tickets/{$ticket->hash}", [
                'user_id' => $user->id,
            ]);

        $response->assertStatus(200);

        $this->assertEquals($ticket->fresh()->user_id, $user->id);
    }

    /** @test */
    public function manually_add_information()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(200);

        $ticket->refresh();
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
    }

    /** @test */
    public function name_is_required()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->actingAs($user)
            ->json('patch', "/tickets/{$ticket->hash}", [
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('name');
    }

    /** @test */
    public function email_is_required()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->actingAs($user)
            ->json('patch', "/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('email');
    }

    /** @test */
    public function email_must_be_email()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->actingAs($user)
            ->json('patch', "/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'email' => 'asdf',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('email');
    }

    /** @test */
    public function email_must_not_be_in_users_table()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->actingAs($user)
            ->json('patch', "/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'email' => 'jo@example.com',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('email');
    }

    /** @test */
    public function tshirt_is_required()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->actingAs($user)
            ->json('patch', "/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('tshirt');
    }

    /** @test */
    public function all_other_data_is_returned_from_validator()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => null,
        ]);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->patch("/tickets/{$ticket->hash}", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
            ]);

        $response->assertStatus(200);

        $ticket->refresh();
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
    }

    /** @test */
    public function can_update_profile_information_for_manually_entered_user()
    {
        $coordinator = factory(User::class)->create(['email' => 'hgranger@example.com']);
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $ticket = factory(Ticket::class)->create([
            'user_id' => $user->id,
            'type' => 'manual',
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($coordinator)
            ->json('patch', "/profile/{$user->id}", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'L',
                'accommodation' => 'My scar hurts sometimes',
                'agreement' => true,
            ]);

        $response->assertStatus(200);

        $ticket->refresh();
        $this->assertNotNull($ticket->user_id);
        $this->assertEquals('Harry Potter', $ticket->user->name);
        $this->assertEquals('hpotter@hogwarts.edu', $ticket->user->email);
        $this->assertEquals('he, him, his', $ticket->user->profile->pronouns);
        $this->assertEquals('Straight', $ticket->user->profile->sexuality);
        $this->assertEquals('Male', $ticket->user->profile->gender);
        $this->assertEquals('White', $ticket->user->profile->race);
        $this->assertEquals('Hogwarts', $ticket->user->profile->college);
        $this->assertEquals('L', $ticket->user->profile->tshirt);
    }
}
