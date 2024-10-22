x<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('code',255);
            $table->enum('amount_type', ['fixed', 'rate'])->default('rate');
            $table->double('amount');
            $table->integer('num_uses')->nullable();
            $table->date('expiry_date')->nullable();
            $table->tinyInteger('is_active')->comment("1 =>yes, 0=>no")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
