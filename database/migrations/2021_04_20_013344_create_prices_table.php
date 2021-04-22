<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_type_id')->constrained('ticket_types');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->integer('step')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
        });
    }
}
