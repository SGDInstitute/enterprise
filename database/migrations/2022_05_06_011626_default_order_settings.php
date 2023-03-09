<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Setting::create(['group' => 'orders.thank-you-modal', 'name' => 'title', 'type' => 'string', 'payload' => 'Thank You!']);
        Setting::create(['group' => 'orders.thank-you-modal', 'name' => 'content', 'type' => 'string', 'payload' => 'Your order is greatly appreciated.']);

        Setting::create(['group' => 'emails.order-receipt', 'name' => 'subject', 'type' => 'string', 'payload' => 'Thank you for ordering tickets for {event}']);
        Setting::create(['group' => 'emails.order-receipt.content', 'name' => 'card', 'type' => 'string', 'payload' => "You were charged {amount} for {tickets} tickets to {event}.\nThe Midwest Institute for Sexuality and Gender Diversity is a public charity recognized as tax-exempt by the IRS under Section 501(c)(3) and your gift may qualify as a charitable deduction for federal income tax purposes. Our tax ID is 81-1788851."]);
        Setting::create(['group' => 'emails.order-receipt.content', 'name' => 'check', 'type' => 'string', 'payload' => "We have recieved your check for {amount} for {tickets} tickets to {event}.\nThe Midwest Institute for Sexuality and Gender Diversity is a public charity recognized as tax-exempt by the IRS under Section 501(c)(3) and your gift may qualify as a charitable deduction for federal income tax purposes. Our tax ID is 81-1788851."]);
    }
};
