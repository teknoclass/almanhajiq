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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_sections_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('accessibility', ['free','paid'])->index();
            $table->integer('downloadable');
            $table->enum('storage', ['upload','youtube','external_link','google_drive','iframe'])->index()->nullable();
            $table->text('file');
            $table->char('file_type');
            $table->char('volume')->default(0);
            $table->enum('status', ['active','inactive'])->index();
            $table->integer('order')->default(0);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('course_sections_id')->references('id')->on('course_sections')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
