<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Wnx\SidecarBrowsershot\BrowsershotLambda;

class PrintOneOffBadge extends Command implements PromptsForMissingInput
{
    protected $signature = 'app:print-one-off {name} {pronouns}';

    protected $description = 'Print One Off Badge';

    protected $label = ['name' => '50', 'width' => 1164, 'height' => 554];

    public function handle(): void
    {
        $this->process($this->label, $this->argument('name'), $this->argument('pronouns'));
    }

    public function process($label, $name, $pronouns)
    {
        $pronouns = $this->formatPronouns($pronouns);
        $slug = Str::slug($name);
        $view = view('components.bit.namebadge-label', ['name' => $name, 'pronouns' => $pronouns])->render();
        $path = storage_path("app/labels/{$slug}.png");

        $result = BrowsershotLambda::html($view)
            ->windowSize($label['width'], $label['height'])
            ->save($path);

        $this->info("Printing: {$name} : {$pronouns}");

        $output = null;
        $result = null;
        exec("brother_ql -b pyusb print -l {$label['name']} {$path} 2>&1", $output, $result);

        Log::debug($output);
        Log::debug($result);
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
