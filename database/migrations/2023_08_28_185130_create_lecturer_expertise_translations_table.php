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
        Schema::create('lecturer_expertise_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('lecturer_expertise_id');
            $table->string('locale')->index();

            $table->text('name')->nullable();
            $table->text('description')->nullable();

            $table->unique(['lecturer_expertise_id','locale'], 'unique_lecturer_expertise_translation');
            $table->foreign('lecturer_expertise_id')->references('id')->on('lecturer_expertises')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_expertise_translations');
    }
};
