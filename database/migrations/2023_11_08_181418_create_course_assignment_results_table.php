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
        Schema::create('course_assignment_results', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('assignment_id');
            $table->enum('status', \App\Models\CourseAssignmentResults::$assignmentStatus);
            $table->integer('grade')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->text('results')->nullable();

            $table->foreign('course_id', 'assignment_course_foreign')->on('courses')->references('id')->cascadeOnDelete();
            $table->foreign('lecturer_id', 'assignment_teacher_foreign')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('student_id', 'assignment_student_foreign')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('assignment_id', 'assignment_result_foreign')->on('course_assignments')->references('id')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assignment_questions_answers');
    }
};
