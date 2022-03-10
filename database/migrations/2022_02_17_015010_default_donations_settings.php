<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultDonationsSettings extends Migration
{
    public function up()
    {
        Setting::create(['group' => 'donations.page', 'name' => 'title', 'type' => 'string', 'payload' => 'Support Our Work']);
        Setting::create(['group' => 'donations.page', 'name' => 'image', 'type' => 'string', 'payload' => 'https://sgdinstitute.org/assets/headers/header-test2.jpg']);
        Setting::create(['group' => 'donations.page', 'name' => 'content', 'type' => 'string', 'payload' => "The Midwest Institute for Sexuality and Gender Diversity re-envisions an educational climate that centers the needs and experiences of systemically disadvantaged students and affirms and encourages sexuality and gender diversity.\n\nOur life-saving work is made possible through the generous financial support of grassroots donors. We invite you to join us with a monthly or one-time gift. Your donation will support our efforts to build community and build strong movements."]);

        Setting::create(['group' => 'donations.page', 'name' => 'onetime', 'type' => 'array', 'payload' => [10,20,50,100,'other']]);
        Setting::create(['group' => 'donations.page', 'name' => 'monthly', 'type' => 'array', 'payload' => [
            "price_1KUfATI7BmcylBPUUj62a4SP" => "5",
            "price_1KUfAaI7BmcylBPUEx5dn0Ky" => "10",
            "price_1KUfAeI7BmcylBPU51hT3mIC" => "20",
            "price_1KUfAjI7BmcylBPUjAGaWUE6" => "25",
            "price_1KUfAmI7BmcylBPUHNKw7EpJ" => "50",
            "price_1KUfApI7BmcylBPUTgdop1HT" => "100"
        ]]);

        Setting::create(['group' => 'donations.thank-you-modal', 'name' => 'title', 'type' => 'string', 'payload' => 'Thank You!']);
        Setting::create(['group' => 'donations.thank-you-modal', 'name' => 'content', 'type' => 'string', 'payload' => 'Your donation is greatly appreciated.']);
    }
}
