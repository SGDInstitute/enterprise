<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

Artisan::command('print:all', function () {
    $url = env('PROD_URL');

    while (true) {
        $this->info('Getting attendees');
        $attendees = Http::get($url.'/api/queue')->json();

        foreach ($attendees as $attendee) {
            $slug = Str::slug($attendee['name']);
            $view = view('components.bit.namebadge-label', ['name' => $attendee['name'], 'pronouns' => $attendee['pronouns']])->render();
            $path = storage_path("app/labels/{$slug}.png");

            Browsershot::html($view)
                ->windowSize(991, 306)
                ->save($path);

            $this->info("Printing: {$attendee['name']} : {$attendee['pronouns']}");
            exec("brother_ql -b pyusb print -l 29x90 {$path}");

            Http::post($url."/api/queue/{$attendee['ticket_id']}/printed");
        }

        $this->info('Sleeping for 30 seconds');
        sleep(30);
    }
});

Artisan::command('print:test', function () {
    $attendee = [
        'name' => fake()->name,
        'pronouns' => fake()->randomElement(['she/her', 'he/him', 'they/them', 'zie/zir', 'Any Pronouns']),
    ];

    $slug = Str::slug($attendee['name']);
    $view = view('components.bit.namebadge-label', ['name' => $attendee['name'], 'pronouns' => $attendee['pronouns']])->render();
    $path = storage_path("app/labels/{$slug}.png");

    Browsershot::html($view)
        ->windowSize(991, 306) // 29mm x 90mm die cut
        ->save($path);

    $this->info("Printing: {$attendee['name']} : {$attendee['pronouns']}");
    exec("brother_ql -b pyusb print -l 29x90 {$path}");
});
