<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBulletinsTable extends Migration
{
    public function up()
    {
        Schema::create('event_bulletins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->string('title');
            $table->text('content');
            $table->dateTime('published_at');
            $table->string('timezone');
            $table->timestamps();
        });
    }
}
