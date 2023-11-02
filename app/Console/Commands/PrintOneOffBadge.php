<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class PrintOneOffBadge extends Command implements PromptsForMissingInput
{
    protected $signature = 'app:print-one-off {name} {pronouns}';

    protected $description = 'Print One Off Badge';

    protected $label = ['name' => '50x100', 'width' => 1109, 'height' => 600];

    public function handle(): void
    {
        $this->process($this->label, $this->argument('name'), $this->argument('pronouns'));
    }

    public function process($label, $name, $pronouns, $ticketId = null)
    {
        $pronouns = $this->formatPronouns($pronouns);
        $slug = Str::slug($name);
        $view = view('components.bit.namebadge-label', ['name' => $name, 'pronouns' => $pronouns])->render();
        $path = storage_path("app/labels/{$slug}.png");

        $result = Browsershot::html($view)
            ->newHeadless()
            ->setNodeBinary('/usr/local/bin/node')
            ->setNpmBinary('/usr/local/bin/npm')
            ->windowSize($label['width'], $label['height'])
            ->save($path);

        dd($result);

        // $this->info("Printing: {$name} : {$pronouns}");

        // $output = null;
        // $result = null;
        // exec("brother_ql -b pyusb print -l {$label['name']} {$path} 2>&1", $output, $result);

        // if ($ticketId && $this->printSucceeded($output)) {
        //     $this->info('Marking as printed');
        //     Http::post(config('app.url') . "/api/queue/{$ticketId}/printed");
        // }
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => 'Name for Badge',
            'pronouns' => 'Pronouns for Badge',
        ];
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
