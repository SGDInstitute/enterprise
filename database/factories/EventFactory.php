<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'title' => 'Leadership Conference',
        'slug' => 'leadership-conference',
        'stripe' => 'institute',
        'subtitle' => 'Learn something new every day',
        'timezone' => 'America/Denver',
        'place' => 'University of Colorado',
        'location' => 'Denver, CO',
        'start' => Carbon\Carbon::now()->addYear(),
        'end' => Carbon\Carbon::now()->addYear()->addDay(2),
        'links' => [
            ['icon' => 'twitter', 'link' => 'https://twitter.com/leadership', 'order' => 1],
            ['icon' => 'facebook', 'link' => 'https://www.facebook.com/leadership/', 'order' => 2],
            ['icon' => 'instagram', 'link' => 'https://www.instagram.com/leadership', 'order' => 3],
            ['icon' => 'snapchat-ghost', 'link' => 'https://www.snapchat.com/add/leadership', 'order' => 4],
            ['icon' => 'website', 'link' => 'https://leadership.org', 'order' => 5],
        ],
    ];
    }

    public function published()
    {
        return $this->state(function () {
            return [
        'published_at' => \Carbon\Carbon::parse('-1 week'),
    ];
        });
    }

    public function unpublished()
    {
        return $this->state(function () {
            return [
        'published_at' => null,
    ];
        });
    }

    public function future()
    {
        return $this->state(function () {
            return [
        'published_at' => \Carbon\Carbon::parse('+1 month'),
    ];
        });
    }

    public function past()
    {
        return $this->state(function () {
            return [
        'start' => \Carbon\Carbon::parse('-1 year'),
        'end' => \Carbon\Carbon::parse('-1 year')->addDays(2),
    ];
        });
    }
}
