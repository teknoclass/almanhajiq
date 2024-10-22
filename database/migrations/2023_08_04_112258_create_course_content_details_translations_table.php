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
        Schema::create('course_content_details_translations', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('course_content_details_id');
            $table->string('locale')->index();
            $table->string('title',255)->index();
            $table->longText('description')->nullable();
            $table->unique(['course_content_details_id','locale'],'course_content_un');
            $table->foreign('course_content_details_id','course_content_fk')->references('id')->on('course_content_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_content_details_translations');
    }
};
