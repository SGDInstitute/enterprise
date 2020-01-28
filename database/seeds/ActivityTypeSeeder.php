<?php

use App\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = json_decode('[ { "title": "general", "color": "#aeb3bf", "text_color": "#000"}, { "title": "food", "color": "#546163", "text_color": "#ffffff"}, { "title": "keynote", "color": "#f2b716", "text_color": "#000000"}, { "title": "Featured", "color": "#009999", "text_color": "#ffffff"}, { "title": "Workshop", "color": "#1a7796", "text_color": "#ffffff"}, { "title": "group", "color": "#1a7796", "text_color": "#ffffff"}, { "title": "Advisor", "color": "#a13c72", "text_color": "#ffffff"}, { "title": "entertainment", "color": "#f2b716", "text_color": "#000000"}, { "title": "conference", "color": "#009999", "text_color": "#ffffff"}, { "title": "hotel", "color": "#f2b716", "text_color": "#000000"} ]', true);

        foreach ($activities as $type) {
            ActivityType::create($type);
        }
    }
}
