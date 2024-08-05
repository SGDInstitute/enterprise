<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->after('transaction_id')->default('reservation');
        });

        Order::whereNotNull('confirmation_number')->update(['status' => 'succeeded']);
    }
};
