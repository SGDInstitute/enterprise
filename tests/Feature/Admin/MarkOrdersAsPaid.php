<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptEmail;

class MarkOrdetrsAsPaid extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    public function can_mark_orders_as_paid()
    {
        Permission::create(['name' => 'view_dashboard']);
        $admin = factory(User::class)->create();
        $admin->givePermissionTo('view_dashboard');

        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['user_id' => $user]);

        $response = $this->actingAs($admin)->withoutExceptionHandling()
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                'check_number' => '#12345',
                'amount' => '7500',
                'comped' => false,
            ]);

        $order->fresh();

        $response->assertStatus(200);
        $this->assertTrue($order->isPaid());
        $this->assertTrue($order->isCheck());
        $this->assertEquals('#12345', $order->receipt->transaction_id);

        Mail::assertSent(ReceiptEmail::class, function ($mail) use ($order) {
            return $mail->hasTo('jo@example.com')
                && $mail->order->id === $order->id;
        });
    }

    /** @test */
    public function pound_sign_gets_added_if_not_included()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $order = factory(Order::class)->create();

        $response = $this->actingAs($user)->withoutExceptionHandling()
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                'check_number' => '12345',
                'amount' => '7500',
                'comped' => false,
            ]);

        $order->fresh();

        $response->assertStatus(200);
        $this->assertTrue($order->isPaid());
        $this->assertTrue($order->isCheck());
        $this->assertEquals('#12345', $order->receipt->transaction_id);
    }

    /** @test */
    public function can_mark_orders_as_comped()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $order = factory(Order::class)->create();

        $response = $this->actingAs($user)->withoutExceptionHandling()
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                'comped' => true
            ]);

        $order->fresh();

        $response->assertStatus(200);
        $this->assertTrue($order->isPaid());
        $this->assertFalse($order->isCheck());
        $this->assertFalse($order->isCard());
        $this->assertEquals('comped', $order->receipt->transaction_id);
    }

    /** @test */
    public function check_number_is_required()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $order = factory(Order::class)->create();

        $response = $this->actingAs($user)
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                // 'check_number' => '#12345',
                'amount' => '7500',
                'comped' => false,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('check_number');
    }

    /** @test */
    public function amount_is_required()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $order = factory(Order::class)->create();

        $response = $this->actingAs($user)
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                'check_number' => '#12345',
                // 'amount' => '7500',
                'comped' => false,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('amount');
    }

    /** @test */
    public function check_number_and_amount_are_required_if_comped_is_false()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $order = factory(Order::class)->create();

        $response1 = $this->actingAs($user)
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                // 'check_number' => '#12345',
                // 'amount' => '7500',
                'comped' => false
            ]);

        $response2 = $this->actingAs($user)
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                'comped' => true
            ]);

        $response1->assertStatus(422);
        $response1->assertJsonValidationErrors(['amount', 'check_number']);

        $response2->assertStatus(200);
    }

    /** @test */
    public function amount_is_zero_when_order_is_comped()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $order = factory(Order::class)->create();

        $response = $this->actingAs($user)->withoutExceptionHandling()
            ->json('patch', "/admin/orders/{$order->id}/paid", [
                'comped' => true
            ]);

        $order->fresh();

        $response->assertStatus(200);
        $this->assertTrue($order->isPaid());
        $this->assertEquals(0, $order->receipt->amount);
    }
}
