<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('private_lesson_meeting_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('private_lesson_id');
            $table->unsignedBigInteger('meeting_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('lefting_at')->nullable();
            $table->foreign('private_lesson_id')->references('id')->on('private_lessons');
            $table->foreign('meeting_id')->references('id')->on('private_lesson_meetings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_lesson_meeting_participants');
    }
};
