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
        Schema::create('course_assignments_results_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->references('id')->on('course_assignment_questions')->onDelete('cascade');
            $table->foreignId('result_id')->references('id')->on('course_assignment_results')->onDelete('cascade');
            $table->text('answer')->nullable()->default(null);
            $table->string('file')->nullable()->default(null);
            $table->integer('mark')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assignments_results_answers');
    }
};
