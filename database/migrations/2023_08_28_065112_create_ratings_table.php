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
        Schema::create('ratings', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->enum('sourse_type', ['course','user','course_lesson','session_group_course', 'private_lesson'])->index();
            $table->integer('sourse_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->double('rate');
            $table->text('comment_text')->nullable();
            $table->boolean('is_active')->default(1)->index();
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
        Schema::dropIfExists('ratings');
    }
};
