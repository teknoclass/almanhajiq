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
        Schema::create('course_quizzes_questions_answer_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_quizzes_questions_answer_id');
            $table->string('locale')->index();
            $table->string('title',255)->index();
            $table->unique(['course_quizzes_questions_answer_id','locale'],'question_answer_unique');
            $table->foreign('course_quizzes_questions_answer_id', 'quiz_question_answer_foreign')->references('id')->on('course_quizzes_questions_answers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_quizze_question_answer_translations');
    }
};
