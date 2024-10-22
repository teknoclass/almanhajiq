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
        Schema::create('course_session_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('subscription_date')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('related_to_group_subscription')->default(0);
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->unsignedBigInteger('course_session_id');
            $table->foreign('course_session_id')->references('id')->on('course_sessions');
            $table->unsignedBigInteger('course_session_group_id')->nullable();
            $table->foreign('course_session_group_id')->references('id')->on('course_sessions_group');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_session_subscriptions');
    }
};
