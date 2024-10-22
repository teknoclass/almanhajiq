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
            $table->string('welcome_text_for_registration_image', 255)->nullable()->default('registeration.png')->change();
            $table->string('certificate_text_image', 255)->nullable()->default('certificate.png')->change();
            $table->string('faq_image', 255)->nullable()->default('faq.png')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
};
