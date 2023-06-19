<?php

use App\Models\RfpReview;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rfp_reviews', function (Blueprint $table) {
            $table->integer('score')->after('track');
        });

        foreach (RfpReview::all() as $review) {
            $review->update(['score' => $review->alignment + $review->experience + $review->priority + $review->track]);
        }
    }

    public function down(): void
    {
        Schema::table('rfp_reviews', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
};
