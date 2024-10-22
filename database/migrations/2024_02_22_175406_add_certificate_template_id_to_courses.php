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
        Schema::table('courses', function (Blueprint $table) {
            $table->bigInteger('certificate_template_id')->after('certificate_text_image')->nullable()->unsigned();
            $table->foreign('certificate_template_id')->references('id')->on('certificate_templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['certificate_template_id']);
            $table->dropColumn('certificate_template_id');
        });
    }
};
