<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('auction_id')->constrained('auctions')->onDelete('cascade');
        $table->decimal('total_amount', 10, 2);
        $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
        $table->timestamp('transaction_time')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->enum('order_status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
