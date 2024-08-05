<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('donations');
            $table->string('transaction_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->integer('amount');
            $table->string('type');
            $table->string('status')->default('incomplete');
            $table->dateTime('next_bill_date')->nullable();
            $table->timestamps();
            $table->dateTime('ends_at')->nullable();
        });
    }
};
