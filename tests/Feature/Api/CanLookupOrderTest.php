<?php

namespace Tests\Feature\Api;

use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanLookupOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_lookup_order_by_confirmation_number()
    {
        factory(Order::class)->create();
        $order = factory(Order::class)->create(['confirmation_number' => 'ABCDABCDABCDABCD']);

        $response = $this->json('get', '/api/orders/ABCDABCDABCDABCD');

        $response->assertStatus(200);
        $this->assertEquals($order->id, $response->json('id'));
    }

    /** @test */
    public function can_lookup_order_by_order_id()
    {
        factory(Order::class)->create();
        $order = factory(Order::class)->create(['confirmation_number' => 'ABCDABCDABCDABCD']);

        $response = $this->withoutExceptionHandling()->json('get', '/api/orders/'.$order->id);

        $response->assertStatus(200);
        $this->assertEquals($order->id, $response->json('id'));
    }
}
