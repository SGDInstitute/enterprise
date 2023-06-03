<?php

use App\Models\Form;
use App\Models\Response;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rfp_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('form_id')->constrained();
            $table->foreignId('response_id')->constrained();
            $table->tinyInteger('alignment');
            $table->tinyInteger('experience');
            $table->tinyInteger('priority');
            $table->tinyInteger('track');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfp_reviews');
    }
};
