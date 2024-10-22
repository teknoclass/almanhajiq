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
        Schema::table('lecturer_settings', function (Blueprint $table) {
            $table->enum('video_type',['link','file'])->nullable()->after('id');
            $table->text('video')->nullable()->after('video_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturer_settings', function (Blueprint $table) {
            //
        });
    }
};
