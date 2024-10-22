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
        Schema::table('course_quizzes_results', function (Blueprint $table) {
            $table->string('result_token',255)->after('results')->nullable();
        });

        Schema::table('course_assignment_results', function (Blueprint $table) {
            $table->string('result_token',255)->after('results')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_and_assignment', function (Blueprint $table) {
            //
        });
    }
};
