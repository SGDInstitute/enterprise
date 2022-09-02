<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('email')->nullable();
            $table->string('type');
            $table->json('answers');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
};
