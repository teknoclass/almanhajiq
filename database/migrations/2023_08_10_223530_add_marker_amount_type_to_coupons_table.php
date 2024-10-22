<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarkerAmountTypeToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            //
            $table->enum('marketer_amount_type', ['fixed','rate'])->after('is_active')
            ->default('rate')->nullable();

            $table->double('marketer_amount')->after('marketer_amount_type')->nullable();
            $table->double('marketer_amount_of_registration')->after('marketer_amount')
            ->default(0)->comment('مبلغ الذي يحصل عليه المسوق بعد كل عمليه طالب')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            //
        });
    }
}
