<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationPlansTable extends Migration
{
    public function up()
    {
        Schema::create('donation_plans', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_product_id');
            $table->string('stripe_price_id');
            $table->string('name');
            $table->integer('cost');
            $table->timestamps();
        });
    }
}
