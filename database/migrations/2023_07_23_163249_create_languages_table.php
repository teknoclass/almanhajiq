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
        Schema::create('languages', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->string('title',255);
            $table->string('lang',50);
            $table->tinyInteger('is_default')->comment("1 =>yes, 0=>no")->default(0);
            $table->tinyInteger('is_rtl')->comment("1 =>yes, 0=>no")->default(0);
            $table->tinyInteger('is_active')->comment("1 =>yes, 0=>no")->default(0);
            $table->unique(['lang']);
            $table->boolean('can_delete')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
