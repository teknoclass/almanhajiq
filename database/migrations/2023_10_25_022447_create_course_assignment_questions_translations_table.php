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
        Schema::create('course_assignment_questions_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_assignment_questions_id');
            $table->string('locale')->index();
            $table->string('title', 255)->index();
            $table->unique(['course_assignment_questions_id', 'locale'], 'cl_assign_translations_id_locale_unique');
            $table->foreign('course_assignment_questions_id', 'fk_assign_questions_translations')->references('id')->on('course_assignment_questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assignment_questions_translations');
    }
};
