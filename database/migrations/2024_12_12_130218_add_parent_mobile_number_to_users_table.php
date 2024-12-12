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
        Schema::table('users', function (Blueprint $table) {
            $table->string('parent_mobile_number')->nullable();
            $table->string('parent_code_country')->nullable();
            $table->string('parent_slug_country')->nullable();
        });
    }
};
