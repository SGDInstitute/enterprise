<?php

namespace Tests\Unit;

use App\Event;
use App\Order;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_change_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Password1'),
        ]);

        $user->changePassword('Password2');

        $user->fresh();
        $this->assertTrue(Hash::check('Password2', $user->password));
    }

    /** @test */
    public function can_get_user_by_email()
    {
        User::factory()->create([
            'email' => 'jo@example.com',
        ]);

        $foundUser = User::findByEmail('jo@example.com');

        $this->assertNotNull($foundUser);
        $this->assertEquals('jo@example.com', $foundUser->email);
    }

    /** @test */
    public function can_get_email_token()
    {
        $user = User::factory()->create([
            'email' => 'jo@example.com',
        ]);

        $token = $user->createToken('email');

        $this->assertNotNull($user->emailToken);
        $this->assertEquals($token->token, $user->emailToken->token);
        $this->assertEquals($user->id, $token->user_id);
        $this->assertEquals($user->id, $user->emailToken->user_id);
    }

    /** @test */
    public function can_get_magic_token()
    {
        $user = User::factory()->create([
            'email' => 'jo@example.com',
        ]);

        $token = $user->createToken('magic');

        $this->assertNotNull($user->magicToken);
        $this->assertEquals($token->token, $user->magicToken->token);
        $this->assertEquals($user->id, $token->user_id);
        $this->assertEquals($user->id, $user->magicToken->user_id);
    }

    /** @test */
    public function can_get_orders_and_tickets_for_upcoming_events()
    {
        $user = User::factory()->create();
        $ownedOrder = Order::factory()->create(['user_id' => $user]);
        $invitedOrder = Order::factory()->create();
        $invitedOrder->tickets()->save(Ticket::factory()->make(['user_id' => $user->id]));

        $orders = $user->upcomingOrdersAndTickets();

        $this->assertStringContainsString($ownedOrder->id, $orders->pluck('id'));
        $this->assertStringContainsString($invitedOrder->id, $orders->pluck('id'));
    }

    /** @test */
    public function can_get_orders_and_tickets_for_past_events()
    {
        $user = User::factory()->create();
        $pastEvent1 = Event::factory()->past()->create();
        $ownedOrder = Order::factory()->create(['event_id' => $pastEvent1->id, 'user_id' => $user]);
        $pastEvent2 = Event::factory()->past()->create();
        $invitedOrder = Order::factory()->create(['event_id' => $pastEvent2->id]);
        $invitedOrder->tickets()->save(Ticket::factory()->make(['user_id' => $user->id]));

        $orders = $user->pastOrdersAndTickets();

        $this->assertStringContainsString($ownedOrder->id, $orders->pluck('id'));
        $this->assertStringContainsString($invitedOrder->id, $orders->pluck('id'));
    }

    /** @test */
    public function can_test_if_user_is_a_stripe_customer()
    {
        $customer = User::factory()->create(['institute_stripe_id' => 'customer_id']);
        $this->assertTrue($customer->isCustomer('institute'));

        $user = User::factory()->create();
        $this->assertFalse($user->isCustomer('institute'));
    }

    /** @test */
    public function can_get_users_stripe_id()
    {
        $customer = User::factory()->create(['institute_stripe_id' => 'customer_id']);

        $this->assertEquals('customer_id', $customer->getCustomer('institute'));
    }
}
