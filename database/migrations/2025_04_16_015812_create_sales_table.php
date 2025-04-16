<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->integer('points_earned')->nullable();
            $table->integer('points_used')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('amount_paid')->nullable();
            $table->integer('final_price_member')->nullable();
            $table->integer('change')->nullable();
            $table->date('sale_date')->nullable();
            $table->string('sales_product')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
