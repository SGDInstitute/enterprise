<?php

namespace Tests\Unit\Mail;

use App\Models\Invoice;
use App\Mail\InvoiceEmail;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_contains_link_to_order_page()
    {
        $order = Order::factory()->create();
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $email = (new InvoiceEmail($order))->render();

        $this->assertStringContainsString(url('/orders/'.$order->id), $email);
    }

    /** @test */
    public function email_contains_invoice_attachment()
    {
        $order = Order::factory()->create();
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $email = (new InvoiceEmail($order))->build();

        $this->assertNotNull($email->rawAttachments);
    }
}
