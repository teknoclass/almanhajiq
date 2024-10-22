<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `course_quizzes_questions` CHANGE `grade` `grade` DOUBLE(11,1) NOT NULL;");

        DB::statement("ALTER TABLE `course_quizzes` CHANGE `grade` `grade` DOUBLE(11,1) NOT NULL DEFAULT '100', CHANGE `pass_mark` `pass_mark` DOUBLE(11,1) NOT NULL;");

        DB::statement("ALTER TABLE `course_quizzes_results` CHANGE `user_grade` `user_grade` DOUBLE(11,1) NULL DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `course_quizzes_questions` CHANGE `grade` `grade` int(11) NOT NULL;");
        DB::statement("ALTER TABLE `course_quizzes` CHANGE `grade` `grade` int(11) NOT NULL DEFAULT '100' ,
        `pass_mark` `pass_mark` int(11) NOT NULL;");
    }
};
