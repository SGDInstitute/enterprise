<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class MessageBoardTagsSeeder extends Seeder
{
    public $states = [
        'North Dakota',
        'South Dakota',
        'Nebraska',
        'Kansas',
        'Minnesota',
        'Iowa',
        'Missouri',
        'Wisconsin',
        'Illinois',
        'Michigan',
        'Michigan (UP)',
        'Indiana',
        'Kentucky',
        'Ohio',
    ];

    public $types = [
        'Travel',
        'Lodging',
    ];

    public function run(): void
    {
        foreach ($this->types as $type) {
            Tag::findOrCreate($type, 'threads');
        }

        foreach ($this->states as $state) {
            Tag::findOrCreate($state, 'threads');
        }
    }
}
