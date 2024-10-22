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
        Schema::table('packages', function (Blueprint $table) {
            $table->after('num_hours' , function (Blueprint $table) {
                $table->enum('type' , ['free' , 'featured' , 'best_seller'])->default('free');
                $table->string('color' , 50)->nullable();
                $table->integer('num_months')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('color');
            $table->dropColumn('num_months');
        });
    }
};
