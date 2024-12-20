<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            // إضافة الحقول الجديدة
            $table->timestamp('announcement_start_time')->nullable()->after('end_time');
            $table->timestamp('announcement_end_time')->nullable()->after('announcement_start_time');
            $table->timestamp('inspection_start_time')->nullable()->after('announcement_end_time');
            $table->timestamp('inspection_end_time')->nullable()->after('inspection_start_time');
            $table->decimal('minimum_price', 10, 2)->nullable()->after('status');
            $table->decimal('starting_price', 10, 2)->nullable()->after('minimum_price');
            $table->decimal('minimum_bid', 10, 2)->nullable()->after('starting_price');
            $table->string('main_image')->nullable()->after('minimum_bid');
            $table->decimal('insurance_fee', 10, 2)->nullable()->after('main_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            // حذف الحقول في حالة التراجع عن الهجرة
            $table->dropColumn([
                'announcement_start_time',
                'announcement_end_time',
                'inspection_start_time',
                'inspection_end_time',
                'minimum_price',
                'starting_price',
                'minimum_bid',
                'main_image',
                'insurance_fee',
            ]);
        });
    }
}
