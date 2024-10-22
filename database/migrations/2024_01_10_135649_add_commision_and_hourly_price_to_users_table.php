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
        Schema::table('users', function (Blueprint $table) {
            $table->double('system_commission')->after('city')->nullable();
            $table->text('system_commission_reason')->after('system_commission')->nullable();
            $table->double('hour_price')->after('system_commission_reason')->nullable();
            $table->integer('min_student_no')->after('hour_price')->nullable();
            $table->integer('max_student_no')->after('min_student_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
