<?php

namespace Tests\Unit\Mail;

use App\Mail\ReceiptEmail;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function email_contains_link_to_order_page()
    {
        $order = factory(Order::class)->create();

        $email = (new ReceiptEmail($order))->render();

        $this->assertContains('/orders/' . $order->id, $email);
    }
}
