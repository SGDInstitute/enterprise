<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventItemsTable extends Migration
{
    public function up()
    {
        Schema::create('event_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('parent_id')->nullable()->constrained('event_items');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('timezone');
            $table->string('location')->nullable();
            $table->schemalessAttributes('settings');
            $table->timestamps();
        });
    }
}
