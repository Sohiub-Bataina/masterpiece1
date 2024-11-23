<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->string('phone_number', 20)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('residence')->nullable();
            $table->decimal('insurance_balance', 10, 2)->default(0.00);
            $table->enum('role', ['customer', 'admin', 'superAdmin'])->default('customer');
            $table->boolean('is_deleted')->default(0); // هنا أزلت after()
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
