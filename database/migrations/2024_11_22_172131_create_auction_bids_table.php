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
    Schema::create('auction_bids', function (Blueprint $table) {
        $table->id();
       $table->foreignId('auction_id')->constrained('auctions')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->decimal('bid_amount', 10, 2);
        $table->timestamp('bid_time')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->boolean('is_winner')->default(false);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_bids');
    }
};
