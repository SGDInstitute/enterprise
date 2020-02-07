<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TempLinkCommand extends Command
{
    protected $signature = 'temp:link';

    protected $description = 'Create a symbolic link from "public/temp" to "storage/app/temp"';

    public function handle()
    {
        if (file_exists(public_path('temp'))) {
            return $this->error('The "public/temp" directory already exists.');
        }

        $this->laravel->make('files')->link(
            storage_path('app/temp'),
            public_path('temp')
        );

        $this->info('The [public/temp] directory has been linked.');
    }
}
