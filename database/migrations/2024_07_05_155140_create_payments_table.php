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
        // 'payable_id' , 'payable_type' , 'user_id' , 'payment_method' ,  'amount' ,'operation_id' , 'status' , 'response'
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->morphs('payable');
            $table->integer('user_id');
            $table->string('payment_channel' , 100)->default('stripe');
            $table->string('payment_method' , 100)->default('card');
            $table->double('amount' , 16,2);
            $table->string('status' , 100)->default('pending');
            $table->string('operation_id' , 100)->nullable();
            $table->json('response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
