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
    Schema::create('item_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id')->constrained('customs_items')->onDelete('cascade');
        $table->string('image_url');
        $table->timestamps(); // Created_at & Updated_at
        $table->boolean('is_deleted')->default(false);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_images');
    }
};
