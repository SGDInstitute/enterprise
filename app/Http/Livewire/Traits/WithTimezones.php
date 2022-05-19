<?php

namespace App\Http\Livewire\Traits;

trait WithTimezones
{
    public function getTimezonesProperty()
    {
        return [
            'America/Chicago' => '(GMT-06:00) Central Time (US & Canada)',
            'America/New_York' => '(GMT-05:00) Eastern Time (US & Canada)',
            'America/Adak' => '(GMT-10:00) Hawaii-Aleutian',
            'Etc/GMT+10' => '(GMT-10:00) Hawaii',
            'America/Anchorage' => '(GMT-09:00) Alaska',
            'America/Ensenada' => '(GMT-08:00) Tijuana, Baja California',
            'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US & Canada)',
            'America/Denver' => '(GMT-07:00) Mountain Time (US & Canada)',
            'America/Dawson_Creek' => '(GMT-07:00) Arizona',
        ];
    }
}
