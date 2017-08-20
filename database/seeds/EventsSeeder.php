<?php

use App\Event;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMBLGTACC();
        $this->createMusicFest();
    }

    private function createMBLGTACC()
    {
        $event = Event::create([
            'title' => 'MBLGTACC 2018',
            'subtitle' => 'All Roads Lead to Intersectionality',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
            'slug' => 'mblgtacc-2018',
            'stripe' => 'mblgtacc',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'published_at' => \Carbon\Carbon::now()->subMonth(),
            'links' => [
                'website' => 'https://mblgtacc.org',
            ]
        ]);

        $event->ticket_types()->createMany([
            [
                'name' => 'Regular Ticket',
                'cost' => 6500,
                'availability_start' => \Carbon\Carbon::now()->subMonth(),
                'availability_end' => \Carbon\Carbon::parse('2018-02-16 19:00:00')->subMonth(),
            ],
            [
                'name' => 'Late Ticket',
                'description' => 'You are not guarenteed special items such as T-Shirts, Program Books, etc. Extras will be available on Sunday after the closing ceremony.',
                'cost' => 6500,
                'availability_start' => \Carbon\Carbon::parse('2018-02-17 19:00:00')->subMonth(),
                'availability_end' => '2018-02-18 19:30:00',
            ],
        ]);
    }

    private function createMusicFest()
    {
        $nextYear = date('Y') + 1;
        $start = \Carbon\Carbon::parse("last saturday of june {$nextYear}");
        $end = $start->addDay();

        $event = Event::create([
            'title' => 'Music Fest',
            'timezone' => 'America/New_York',
            'place' => 'Dome',
            'location' => 'Indianapolis, Indiana',
            'slug' => 'music-fest',
            'stripe' => 'institute',
            'start' => \Carbon\Carbon::parse("last saturday of june {$nextYear}"),
            'end' => $end,
            'published_at' => \Carbon\Carbon::now()->subMonth(),
            'links' => [
                'website' => 'https://mblgtacc.org',
            ]
        ]);

        $event->ticket_types()->createMany([
            [
                'name' => 'Lawn Ticket',
                'cost' => 2500,
            ],
            [
                'name' => '200 Section',
                'cost' => 5000,
            ],
            [
                'name' => '100 Section',
                'cost' => 10000,
            ]
        ]);
    }
}
