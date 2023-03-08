<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class PrintBadges extends Command
{
    protected $signature = 'print:badges {name?} {pronouns?} {label=62x100} {--queue}';

    protected $description = 'Print MBLGTACC conference badges';

    protected $labels = [
        '62x100' => ['name' => '62x100', 'width' => 1109, 'height' => 696],
        '29x90' => ['name' => '29x90', 'width' => 991, 'height' => 306],
    ];

    public function handle(): void
    {
        $label = $this->labels[$this->argument('label')];

        if (! $this->option('queue')) {
            $this->process($label, $this->argument('name'), $this->argument('pronouns'));

            return;
        }

        while (true) {
            $this->info('Getting attendees');
            $attendees = Http::get(env('PROD_URL').'/api/queue')->json();

            foreach ($attendees as $attendee) {
                $this->process($label, $attendee['name'], $attendee['pronouns'], $attendee['ticket_id']);
            }

            $this->info('Sleeping for 30 seconds');
            sleep(30);
        }
    }

    public function process($label, $name, $pronouns, $ticketId = null)
    {
        $pronouns = $this->formatPronouns($pronouns);
        $slug = Str::slug($name);
        $view = view('components.bit.namebadge-label', ['name' => $name, 'pronouns' => $pronouns])->render();
        $path = storage_path("app/labels/{$slug}.png");

        Browsershot::html($view)
            ->windowSize($label['width'], $label['height'])
            ->save($path);

        $this->info("Printing: {$name} : {$pronouns}");

        $output = null;
        $result = null;
        exec("brother_ql -b pyusb print -l {$label['name']} {$path} 2>&1", $output, $result);

        if ($ticketId && $this->printSucceeded($output)) {
            $this->info('Marking as printed');
            Http::post(env('PROD_URL')."/api/queue/{$ticketId}/printed");
        }
    }

    private function formatPronouns($pronouns)
    {
        return Str::of($pronouns)->replace('/', ', ');
    }

    private function printSucceeded($printOutput)
    {
        return in_array('INFO:brother_ql.backends.helpers:Printing was successful. Waiting for the next job.', $printOutput);
    }
}
