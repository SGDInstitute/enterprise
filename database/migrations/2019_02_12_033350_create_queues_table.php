<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch');
            $table->unsignedInteger('ticket_id');
            $table->string('name');
            $table->string('pronouns')->nullable();
            $table->string('college')->nullable();
            $table->string('tshirt')->nullable();
            $table->dateTime('order_created');
            $table->dateTime('order_paid')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
}
