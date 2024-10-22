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
        Schema::create('our_teams_translations', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->unsignedBigInteger('our_teams_id');
            $table->string('locale')->index();
            $table->string('name',255);
            $table->string('job',300);
            $table->string('description',255);
            $table->unique(['our_teams_id','locale']);
            $table->foreign('our_teams_id')->references('id')->on('our_teams')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_teams_translations');
    }
};
