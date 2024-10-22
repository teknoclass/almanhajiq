<?php

use App\Models\Transactios;
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
        Schema::table('balances', function (Blueprint $table) {
            $table->after('type' , function (Blueprint $table) {
                $table->foreignIdFor(Transactios::class , 'pay_transaction_id')->nullable();
                $table->boolean('is_paid')->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->dropForeignIdFor('pay_transaction_id');
            $table->dropColumn('is_paid');
        });
    }
};
