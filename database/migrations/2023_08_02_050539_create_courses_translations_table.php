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
        Schema::create('courses_translations', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('courses_id');
            $table->string('locale')->index();
            $table->string('title',255)->index();
            $table->longText('description');
            $table->longText('welcome_text_for_registration')->nullable();
            $table->longText('certificate_text')->nullable();
            $table->longText('free_trial_text')->nullable();
            $table->unique(['courses_id','locale']);
            $table->foreign('courses_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_translations');
    }
};
