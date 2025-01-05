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
        Schema::create('user_wishlist', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign Key
            $table->foreignId('auction_id')->constrained('auctions')->onDelete('cascade'); // Foreign Key (بدلاً من item_id)
            $table->timestamps(); // Created_at, Updated_at
            $table->boolean('is_deleted')->default(false); // Soft Delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wishlist');
    }
};
