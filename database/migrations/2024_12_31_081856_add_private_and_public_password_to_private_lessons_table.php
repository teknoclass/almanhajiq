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
        Schema::table('private_lessons', function (Blueprint $table) {
            $table->string('public_password')->nullable()->default(null);
            $table->string('private_password')->nullable()->default(null);
            $table->string('meeting_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('private_lessons', function (Blueprint $table) {
            $table->string('public_password');
            $table->string('private_password');
            $table->string('meeting_id');
        });
    }
};
