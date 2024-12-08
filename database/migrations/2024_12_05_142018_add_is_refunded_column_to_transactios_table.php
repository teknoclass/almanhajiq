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
            $table->boolean("is_refunded")->default(0);
            $table->string("refund_id")->nullable();
        });
    }

};
