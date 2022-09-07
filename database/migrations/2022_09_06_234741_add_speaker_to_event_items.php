<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_items', function (Blueprint $table) {
            $table->string('speaker')->nullable()->after('slug');
        });
    }
};
