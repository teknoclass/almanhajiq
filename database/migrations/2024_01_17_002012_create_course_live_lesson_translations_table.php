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
        Schema::create('course_live_lesson_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_live_lesson_id');
            $table->string('locale')->index();
            $table->string('title',255)->index();
            $table->text('description');
            $table->unique(['course_live_lesson_id','locale'] ,  'c_live_lessons_translations_id_locale_unique');
            $table->foreign('course_live_lesson_id')->references('id')->on('course_lessons')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_live_lesson_translations');
    }
};
