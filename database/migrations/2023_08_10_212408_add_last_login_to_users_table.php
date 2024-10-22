<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastLoginToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->timestamp('last_login_at')->after('device_token')->nullable();
            $table->unsignedBigInteger('market_id')
            ->after('last_login_at')
            ->nullable()->comment('هل سجل عبر مسوق');
            $table->unsignedBigInteger('coupon_id')
            ->after('last_login_at')
            ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
