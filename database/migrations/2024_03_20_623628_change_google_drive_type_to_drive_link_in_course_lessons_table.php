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
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->enum('storage',['upload','youtube','external_link','drive_link','iframe','vimeo_link'])->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('course_lessons', function (Blueprint $table) {
            $table->enum('storage',['upload','youtube','external_link','drive_link','iframe'])
                  ->change();
        });
    }
};
