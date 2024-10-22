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
        Schema::create('category_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->float('online_price')->default(0.00);
            $table->float('online_discount')->nullable();
            $table->float('offline_price')->default(0.00);
            $table->float('offline_discount')->nullable();
            $table->boolean('accept_group')->default(0);
            $table->float('online_group_min_no')->nullable();
            $table->float('online_group_max_no')->nullable();
            $table->float('online_group_price')->nullable();
            $table->float('offline_group_min_no')->nullable();
            $table->float('offline_group_max_no')->nullable();
            $table->float('offline_group_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_prices');
    }
};
