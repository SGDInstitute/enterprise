<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('donations');
            $table->string('transaction_id')->nullable();
            $table->integer('amount');
            $table->string('type');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
}
