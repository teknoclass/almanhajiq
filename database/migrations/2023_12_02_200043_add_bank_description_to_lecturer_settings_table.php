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
            $table->integer('bank_id')->nullable()->after('youtube');
            $table->string('account_num')->nullable()->after('bank_id');
            $table->string('name_in_bank')->nullable()->after('account_num');
            $table->string('iban')->nullable()->after('name_in_bank');
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
