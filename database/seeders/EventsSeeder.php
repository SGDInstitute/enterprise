<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $mblgtacc = Event::factory()->preset('mblgtacc')->create(['name' => 'MBLGTACC 2024', 'location' => 'Marquette, MI', 'timezone' => 'America/Detroit']);

        $inPerson = TicketType::create(['event_id' => $mblgtacc->id, 'stripe_product_id' => 'prod_JMv3xouI9pZ6Vp', 'name' => 'In-person Attendee', 'structure' => 'flat', 'start' => '2021-04-01 22:34:00', 'end' => '2021-10-10 22:33:00', 'timezone' => 'America/Chicago']);
        $inPerson->prices()->create(['name' => 'Regular', 'stripe_price_id' => 'price_1IkBDgI7BmcylBPU2P1RSoKR', 'cost' => 10000, 'start' => '2024-04-26 00:00:00', 'end' => '2024-10-08 04:59:59', 'timezone' => 'America/Detroit']);
        $inPerson->prices()->create(['name' => 'On-site', 'stripe_price_id' => 'price_1IkBDgI7BmcylBPUqQuVAmdm', 'cost' => 10000, 'start' => '2024-10-08 05:00:00', 'end' => '2021-10-10 22:33:00', 'timezone' => 'America/Detroit']);

        $tjt = Event::factory()->preset('tjt')->create();
    }
}
