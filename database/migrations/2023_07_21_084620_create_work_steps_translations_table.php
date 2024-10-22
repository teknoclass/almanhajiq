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
        Schema::create('work_steps_translations', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('work_steps_id');
            $table->string('locale')->index();
            $table->longText('text');
            $table->unique(['work_steps_id','locale'], 'work_steps_un');
            $table->foreign('work_steps_id', 'work_steps_fk')->references('id')->on('work_steps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_steps_translations');
    }
};
