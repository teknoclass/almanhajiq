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
        Schema::create('lecturer_setting_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('lecturer_setting_id');
            $table->string('locale')->index();

            $table->text('abstract')->nullable();
            $table->text('description')->nullable();
            $table->text('position')->nullable();

            $table->unique(['lecturer_setting_id','locale']);
            $table->foreign('lecturer_setting_id')->references('id')->on('lecturer_settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_setting_translations');
    }
};
