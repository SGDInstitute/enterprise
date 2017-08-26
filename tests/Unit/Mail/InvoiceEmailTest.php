<?php

namespace Tests\Unit\Mail;

use App\Invoice;
use App\Mail\InvoiceEmail;
use App\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function email_contains_link_to_order_page()
    {
        $order = factory(Order::class)->create();
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $email = (new InvoiceEmail($order))->render();

        $this->assertContains(url('/orders/' . $order->id), $email);
    }
}