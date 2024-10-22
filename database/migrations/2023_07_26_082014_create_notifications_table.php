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
        Schema::create('notifications', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->string('title',255);
            $table->text('text')->nullable();
            $table->string('title_en',255)->nullable();
            $table->text('text_en')->nullable();
            $table->string('image')->nullable();
            $table->string('action_type')->nullable();
            $table->string('action_id')->nullable();
            $table->integer('user_id');
            $table->enum('user_type', ['admin', 'user']);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
