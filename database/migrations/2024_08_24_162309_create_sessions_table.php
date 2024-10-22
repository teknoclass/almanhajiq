<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('course_sessions_group')->onDelete('set null');
            $table->string('day');
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_sessions');
    }
};
