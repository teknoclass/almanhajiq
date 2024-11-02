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
        \DB::statement("UPDATE course_quizzes SET start_date = CONCAT(start_date, ' 00:00:00') WHERE start_date IS NOT NULL AND LENGTH(start_date) = 10");
        \DB::statement("UPDATE course_quizzes SET end_date = CONCAT(end_date, ' 00:00:00') WHERE end_date IS NOT NULL AND LENGTH(end_date) = 10");

        Schema::table('course_quizzes', function (Blueprint $table) {
            $table->dateTime('start_date')->nullable()->change();
            $table->dateTime('end_date')->nullable()->change(); 
        });
    }


};
