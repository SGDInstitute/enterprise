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
            $table->foreignId('donation_plan_id')->nullable()->constrained('donation_plans');
            $table->string('confirmation_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('type');
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_company')->default(false);
            $table->string('company_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
        });
    }
}
