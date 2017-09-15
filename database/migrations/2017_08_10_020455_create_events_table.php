<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('timezone');
            $table->string('place');
            $table->string('stripe');
            $table->text('location');
            $table->text('slug');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('links');
            $table->text('image')->nullable();
            $table->text('logo_light')->nullable();
            $table->text('logo_dark')->nullable();
            $table->string('ticket_string')->nullable();
            $table->dateTime('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
