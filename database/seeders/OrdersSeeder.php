<?php

namespace Database\Seeders;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $index) {
            $event = Event::all()->random();
            $ticketType = $event->ticket_types->random();
            $order = $event->orderTickets(User::factory()->create(), [
                ['ticket_type_id' => $ticketType->id, 'quantity' => rand(1, 25)],
            ]);

            if (rand(0, 1)) {
                $order->markAsPaid($this->charge($order->amount));
            }
        }
    }

    private function charge($amount)
    {
        $paymentGateway = new FakePaymentGateway;

        return $paymentGateway->charge($amount, $paymentGateway->getValidTestToken());
    }
}
