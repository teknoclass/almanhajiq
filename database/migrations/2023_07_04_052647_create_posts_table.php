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
        Schema::create('posts', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->string('image',255);
            $table->unsignedInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('num_views')->default(0);
            $table->tinyInteger('is_published')->comment("1 =>yes, 0=>no")->default(1);
            $table->tinyInteger('is_special')->comment("1 =>yes, 0=>no")->default(0);
            $table->date('date_publication');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
