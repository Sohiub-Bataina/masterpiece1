<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('auction_name');
            $table->timestamp('start_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['pending', 'active', 'ended', 'cancelled'])->default('pending');
            $table->timestamps(); 
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('announcement_start_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('item_id')->unsigned(); 
            $table->foreign('item_id')
                  ->references('id') 
                  ->on('customs_items') 
                  ->onDelete('cascade') 
                  ->onUpdate('cascade'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};

