<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use App\User;

class SearchByInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_search_by_invoice_number()
    {
        Permission::create(['name' => 'view_dashboard']);
        $admin = factory(User::class)->create();
        $admin->givePermissionTo('view_dashboard');

        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($admin)->get('/admin/invoices/' . $invoice->id);

        $response->assertRedirect('/admin/orders/' . $invoice->order->id);
    }
}
