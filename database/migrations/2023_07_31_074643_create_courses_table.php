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
        Schema::create('courses', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('image', 255);
            $table->string('welcome_text_for_registration_image', 255)->nullable();
            $table->string('certificate_text_image', 255)->nullable();
            $table->string('faq_image', 255)->nullable();
            $table->string('cover_image', 255);
            $table->string('video_image', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('number_of_free_lessons')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('language_id');
            $table->integer('category_id');
            $table->integer('age_range_id');
            $table->integer('level_id');
            $table->enum('type', ['recorded', 'live'])->index();
            $table->double('total_rate')->default(0);
            $table->boolean('is_active')->default(1)->index();
            $table->boolean('lessons_follow_up')->default(1)->index();
            $table->enum('status', ['being_processed', 'ready', 'unaccepted', 'accepted'])->default('being_processed');
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
        Schema::dropIfExists('courses');
    }
};
