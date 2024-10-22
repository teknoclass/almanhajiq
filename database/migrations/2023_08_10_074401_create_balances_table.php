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
        Schema::create('balances', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->text('description');
            $table->integer('transaction_id');
            $table->string('transaction_type',255);
            $table->unsignedBigInteger('user_id')->index();
            $table->double('amount');
            $table->double('system_commission')->default(0);
            $table->double('amount_before_commission')->nullable();
            $table->enum('type', ['deposit','withdrow'])->default('deposit');
            $table->boolean('is_retractable')->default(1);
            $table->timestamp('becomes_retractable_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
