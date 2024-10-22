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
        Schema::create('private_lessons', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id')->index();
            $table->unsignedBigInteger('student_id')->nullable()->index();
            $table->enum('meeting_type', ['online', 'offline', 'both']);
            $table->float('price')->default(0);
            $table->tinyInteger('is_rated')->default(0);
            $table->boolean('accept_group')->default(0);
            $table->integer('student_no')->default(0);
            $table->date('meeting_date');
            $table->time('time_form');
            $table->time('time_to');
            $table->text('meeting_link')->nullable();
            $table->enum('status', ['pending', 'acceptable', 'unacceptable'])->default('pending');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_lessons');
    }
};
