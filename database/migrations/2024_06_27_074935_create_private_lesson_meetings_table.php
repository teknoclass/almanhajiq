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
        Schema::create('private_lesson_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('private_lesson_id');
            $table->string('app_id')->nullable();
            $table->string('token')->nullable();
            $table->string('app_certificate')->nullable();
            $table->string('channel')->nullable();
            $table->string('url')->nullable();
            $table->string('uid')->nullable();
            $table->enum('status',['active','finished'])->default('active');
            $table->foreign('private_lesson_id')->references('id')->on('private_lessons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_lesson_meetings');
    }
};
