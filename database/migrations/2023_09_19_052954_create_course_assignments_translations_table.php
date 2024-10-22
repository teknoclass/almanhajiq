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
        Schema::create('course_assignments_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_assignments_id');
            $table->string('locale')->index();
            $table->string('title',255)->index();
            $table->text('description');
            $table->unique(['course_assignments_id','locale'], 'assignment_translation_unique');
            $table->foreign('course_assignments_id', 'assignment_translation_foreign')->references('id')->on('course_assignments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assignment_translations');
    }
};
