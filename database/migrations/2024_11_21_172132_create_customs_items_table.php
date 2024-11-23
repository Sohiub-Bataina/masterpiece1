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
    Schema::create('customs_items', function (Blueprint $table) {
        $table->id();
        $table->string('item_name');
        $table->text('item_description')->nullable();
        $table->decimal('base_price', 10, 2);
        $table->foreignId('auction_id')->nullable()->constrained('auctions')->nullOnDelete();
        $table->timestamps(); // Created_at & Updated_at
        $table->boolean('is_deleted')->default(false);
        $table->enum('manager_approval', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('rejection_reason')->nullable();
        $table->integer('quantity')->default(0);
        $table->foreignId('category_id')->nullable()->constrained('category')->nullOnDelete();
        $table->foreignId('brand_id')->nullable()->constrained('brand')->nullOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customs_items');
    }
};
