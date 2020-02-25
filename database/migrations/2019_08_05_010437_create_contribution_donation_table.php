<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionDonationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribution_donation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contribution_id');
            $table->unsignedInteger('donation_id');
            $table->integer('amount');
            $table->integer('quantity');

            $table->foreign('contribution_id')->references('id')->on('contributions');
            $table->foreign('donation_id')->references('id')->on('donations');
        });
    }
}
