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
        Schema::create('course_quizzes_results_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('answer_id')->nullable()->default(null);
            $table->text('text_answer')->nullable()->default(null);
            $table->foreign('result_id')->references('id')->on('course_quizzes_results')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('course_quizzes_questions')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('course_quizzes_questions_answers')->onDelete('cascade');
            $table->integer('mark')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_quizzes_results_answers');
    }
};
