<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->boolean('auth_required')->default(true);
            $table->string('list_id')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('timezone')->nullable();
            $table->json('form')->nullable();
            $table->timestamps();
        });
    }
};
