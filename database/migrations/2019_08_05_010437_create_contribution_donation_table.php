<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger('donation_id');
            $table->integer('amount');
            $table->integer('quantity');

            $table->foreign('contribution_id')->references('id')->on('contributions');
            $table->foreign('donation_id')->references('id')->on('donations');
        });
    }

}
