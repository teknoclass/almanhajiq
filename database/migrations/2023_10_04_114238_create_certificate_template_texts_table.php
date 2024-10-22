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
        Schema::create('certificate_template_texts', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('certificate_template_id');
            $table->longText('text');
            $table->enum('type', ['course_name_location','lecturer_name_location','student_name_location','others'])->default('others');
            $table->string('coordinates', 255);
            $table->string('font_size_css', 255)->nullable();
            $table->string('font_color_css', 255)->nullable();
            $table->string('transform_css', 255)->nullable();
            $table->foreign('certificate_template_id')->references('id')->on('certificate_templates')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_template_texts');
    }
};
