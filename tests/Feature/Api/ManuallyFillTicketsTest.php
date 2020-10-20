<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ManuallyFillTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function manually_add_information_with_hash()
    {
        $ticket = Ticket::factory()->create([
            'user_id' => null,
        ]);

        $response = $this->withoutExceptionHandling()->patch("/api/tickets/{$ticket->hash}", [
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
    }

    /** @test */
    public function manually_add_information_with_id()
    {
        $ticket = Ticket::factory()->create([
            'user_id' => null,
        ]);

        $response = $this->withoutExceptionHandling()->patch("/api/tickets/{$ticket->id}", [
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
    }

    /** @test */
    public function name_is_required()
    {
        $ticket = Ticket::factory()->create([
            'user_id' => null,
        ]);
        $user = User::factory()->create(['email' => 'jo@example.com']);

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
        $ticket = Ticket::factory()->create([
            'user_id' => null,
        ]);
        $user = User::factory()->create(['email' => 'jo@example.com']);

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
        $ticket = Ticket::factory()->create([
            'user_id' => null,
        ]);
        $user = User::factory()->create(['email' => 'jo@example.com']);

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
        $ticket = Ticket::factory()->create([
            'user_id' => null,
        ]);
        $user = User::factory()->create(['email' => 'jo@example.com']);

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
    public function can_update_profile_information_for_manually_entered_user()
    {
        Mail::fake();
        $coordinator = User::factory()->create(['email' => 'hgranger@example.com']);
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $ticket = Ticket::factory()->create([
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
