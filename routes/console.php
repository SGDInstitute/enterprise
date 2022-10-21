<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Wnx\SidecarBrowsershot\BrowsershotLambda;

Artisan::command('print', function () {
    $attendees = [
        ['name' => 'Andy Newhouse', 'pronouns' => 'they/them'],
        ['name' => 'Jess Newhouse', 'pronouns' => 'they/them'],
        ['name' => 'Justin Drwencke', 'pronouns' => 'they/them'],
        ['name' => 'R.B. Brooks', 'pronouns' => 'they/them'],
        ['name' => 'Michelle Walters', 'pronouns' => 'they/them'],
    ];

    foreach ($attendees as $attendee) {
        $slug = Str::slug($attendee['name']);
        $view = "<h1 style='text-align:center;font-size:72px'>{$attendee['name']}</h1><h2 style='text-align:center;font-size:48px'>{$attendee['pronouns']}</h2>";
        $path = storage_path("labels/{$slug}.png");

        BrowsershotLambda::html($view)
            ->windowSize(991, 306)
            ->save($path);

        exec("brother_ql -b pyusb print -l 29x90 {$path}");
    }
})->purpose('Display an inspiring quote');
