<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('responses')->after('user_id');
        });
    }
};
