<?php

namespace Tests\Feature\Livewire\App\Orders;

use PHPUnit\Framework\Attributes\Test;
use App\Livewire\App\Orders\Payment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

final class PaymentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_can_render(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->hasTickets(2)->create();

        Livewire::actingAs($user)
            ->test(Payment::class, ['order' => $order])
            ->assertStatus(200);
    }

    #[Test]
    public function can_download_invoice(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->hasTickets(2)->create();

        Livewire::actingAs($user)
            ->test(Payment::class, ['order' => $order])
            ->call('downloadInvoice')
            ->assertHasErrors([
                'address.line1' => 'required',
                'address.city' => 'required',
                'address.state' => 'required',
                'address.zip' => 'required',
                'address.country' => 'required',
            ])
            ->set('address.line1', '123 Main')
            ->set('address.city', 'Gravesfield')
            ->set('address.state', 'CT')
            ->set('address.zip', '06109')
            ->set('address.country', 'United States')
            ->call('downloadInvoice')
            ->assertFileDownloaded();
    }
}
