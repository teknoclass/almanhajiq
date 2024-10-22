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
        Schema::create('course_live_lessons', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_sections_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('meeting_date');
            $table->time('time_form');
            $table->time('time_to');
            $table->text('meeting_link')->nullable();
            $table->text('recording_link')->nullable();
            $table->enum('status', ['active','inactive'])->index()->default('active');
            $table->enum('meeting', ['pending', 'going_on', 'finished'])->index()->default('pending');
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
        Schema::dropIfExists('course_live_lessons');
    }
};
