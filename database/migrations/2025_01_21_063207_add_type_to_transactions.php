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
        Schema::table('transactios', function (Blueprint $table) {
            $table->string('place')->after('amount')->default('web'); // Adjust 'amount' to the appropriate column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactios', function (Blueprint $table) {
            $table->dropColumn('place');
        });
    }
};
