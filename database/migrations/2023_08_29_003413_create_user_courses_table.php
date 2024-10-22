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
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->integer('level_id')->nullable();
            $table->unsignedBigInteger('lecturer_id')->nullable();
            $table->float('progress')->nullable()->default(0);
            $table->unsignedBigInteger('group_id')->nullable();
            $table->integer('num_students')->default(1);
            $table->string('subscription_token',255)->nullable();
            $table->integer('num_lessons')->nullable();
            $table->boolean('is_end')->default(0);
            $table->boolean('is_get_certificate')->default(0);
            $table->timestamp('certificate_issued_at')->nullable();
            $table->boolean('is_rating')->default(0);
            $table->tinyInteger('is_rating_lecturer')->default(0);
            $table->boolean('is_complete_payment')->default(0);
            $table->boolean('is_free_trial')->default(0);
            $table->integer('num_free_lessons_allowed')->default(0);
            $table->enum('register_sourse', ['website','admin'])->default('website');
            $table->integer('register_by')->nullable();
            $table->tinyInteger('is_lecturer_add_appointments')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_courses');
    }
};
