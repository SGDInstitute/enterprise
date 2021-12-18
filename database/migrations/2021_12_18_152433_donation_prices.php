<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationPrices extends Migration
{
    public function up()
    {
        Schema::table('donation_plans', function (Blueprint $table) {
            $table->dropColumn(['stripe_price_id', 'cost']);
        });

        Schema::create('donation_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('donation_plans');
            $table->string('stripe_price_id');
            $table->string('name');
            $table->integer('cost');
            $table->string('period');
            $table->timestamps();
        });
    }
}
