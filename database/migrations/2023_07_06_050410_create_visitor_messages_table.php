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
        Schema::create('visitor_messages', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->string('name',255);
            $table->string('subject',191);
            $table->text('text');
            $table->timestamp('read_at')->nullable();
            $table->string('mobile')->nullable();
            $table->string('code_country',255)->nullable();
            $table->string('slug_country',255)->nullable();
            $table->string('email',191);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_messages');
    }
};
