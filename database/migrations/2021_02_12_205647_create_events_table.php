<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('timezone');
            $table->string('location')->nullable();
            $table->string('order_prefix')->nullable();
            $table->longText('description')->nullable();
            $table->schemalessAttributes('settings');

            $table->timestamps();
        });
    }
}
