<?php

namespace Database\Seeders;

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
            'title' => 'MBLGTACC 2021',
            'subtitle' => 'From Protest and Beyond Pride',
            'timezone' => 'America/Chicago',
            'place' => 'University of Wisconsin Maddison',
            'location' => 'Maddison, Wisconsin',
            'slug' => 'mblgtacc-2021',
            'stripe' => 'mblgtacc',
            'start' => '2021-02-12 19:00:00',
            'end' => '2021-02-14 19:30:00',
            'ticket_string' => 'attendee',
            'description' => 'The Midwest Bisexual Lesbian Gay Transgender Asexual College Conference (MBLGTACC) is an annual conference held to connect, educate, and empower LGBTQIA+ college students, faculty, and staff around the Midwest and beyond. It has attracted advocates and thought leaders including Angela Davis, Robyn Ochs, Janet Mock, Laverne Cox, Kate Bornstein, Faisal Alam, and LZ Granderson; and entertainers and artists including RuPaul, Margaret Cho, J Mase III, Chely Wright, and Loren Cameron.',
            'published_at' => \Carbon\Carbon::now()->subMonth(),
            'links' => [
                ['icon' => 'twitter', 'link' => 'https://twitter.com/mblgtacc', 'order' => 1],
                ['icon' => 'facebook', 'link' => 'https://www.facebook.com/mblgtacc/', 'order' => 2],
                ['icon' => 'instagram', 'link' => 'https://www.instagram.com/mblgtacc', 'order' => 3],
                ['icon' => 'snapchat-ghost', 'link' => 'https://www.snapchat.com/add/mblgtacc', 'order' => 4],
                ['icon' => 'website', 'link' => 'https://mblgtacc.org', 'order' => 5],
            ],
            'image' => 'https://mblgtacc.org/assets/1855_colton_map_of_the_united_states_-_geographicus_-_unitedstates-colton-1855-publicdomain-cropcolor.jpg',
            'logo_light' => 'https://mblgtacc.org/assets/2021/mblgtacc-2021-horiz_white.png',
            'logo_dark' => 'https://mblgtacc.org/assets/2021/mblgtacc-2021-horiz_gray.png',
            'refund_policy' => '<p>The regular registration rate is available until January 17, 2020. Full refunds are available for cancelled orders until this date. Cancellations received after this date will not be eligible for a refund. Refunds are not available for attendees who choose not to attend the event if the cancellation is not received before the stated cancellation deadline. Orders may be transferred to another attendee at no charge, at any time. Cancellations or transfers must be requested by the user who created the order and should include the name of the attendee. To request a cancellation and refund, or to transfer your ticket to another attendee, please email <a href="mailto:support@sgdinstitute.org">support@sgdinstitute.org</a>.</p>',
        ]);

        $event->ticket_types()->createMany([
            [
                'name' => 'Regular Registration',
                'cost' => 8500,
                'availability_start' => $event->start->subMonth(6),
                'availability_end' => $event->start->subMonth(),
            ],
            [
                'name' => 'Late Registration',
                'description' => 'You are not guarenteed special items such as T-Shirts, Program Books, etc. Extras will be available on Sunday after the closing ceremony.',
                'cost' => 8500,
                'availability_start' => $event->start->subMonth(),
                'availability_end' => $event->end,
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
            'ticket_string' => 'ticket',
            'start' => \Carbon\Carbon::parse("last saturday of june {$nextYear}"),
            'end' => $end,
            'published_at' => \Carbon\Carbon::now()->subMonth(),
            'links' => [
                ['icon' => 'twitter', 'link' => 'https://twitter.com/musicfest', 'order' => 1],
                ['icon' => 'facebook', 'link' => 'https://www.facebook.com/musicfest/', 'order' => 2],
                ['icon' => 'instagram', 'link' => 'https://www.instagram.com/musicfest', 'order' => 3],
                ['icon' => 'snapchat-ghost', 'link' => 'https://www.snapchat.com/add/musicfest', 'order' => 4],
                ['icon' => 'website', 'link' => 'https://musicfest.org', 'order' => 5],
            ],
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
            ],
        ]);
    }
}
