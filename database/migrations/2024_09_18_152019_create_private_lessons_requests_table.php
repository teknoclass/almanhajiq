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
        Schema::create('private_lessons_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('private_lesson_id');
            $table->unsignedBigInteger('user_id'); // Teacher or Student
            $table->string('user_type'); // 'student' or 'teacher'
            $table->enum('type', ['postpone', 'cancel']);
            $table->json('suggested_dates')->nullable(); // For postponement, three suggested dates
            $table->text('optional_files')->nullable(); // JSON for file paths
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string  ('chosen_date')->nullable(); // Chosen date from suggested_dates
            $table->text('admin_response')->nullable(); // Admin notes for rejection or other comments
            $table->timestamps();

            $table->foreign('private_lesson_id')->references('id')->on('private_lessons');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_lessons_requests');
    }
};
