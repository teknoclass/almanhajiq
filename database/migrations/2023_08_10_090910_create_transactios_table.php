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
        Schema::create('transactios', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->text('description')->nullable();
            $table->integer('user_id');
            $table->text('payment_id')->nullable();
            $table->double('amount');
            $table->double('amount_before_discount');
            $table->enum('type', ['deposit','withdrow'])->default('deposit');
            $table->enum('status', ['pinding','refused','completed'])->default('pinding');
            $table->enum('brand', ['paypal','visa','master','mada','apple_pay'])->default('visa');
            $table->longText('transactionable_id');
            // $table->enum('transactionable_type', ['course'])->default('course');
            $table->string('transactionable_type', 255);
            $table->string('coupon',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactios');
    }
};
