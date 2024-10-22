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
        Schema::create('students_opinions_translations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('students_opinions_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('text');
            $table->unique(['students_opinions_id','locale'],'students_opinions_un');
            $table->foreign('students_opinions_id')->references('id')->on('students_opinions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_opinions_translations');
    }
};
