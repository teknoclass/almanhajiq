<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestJoinMarketersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_join_marketers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('mobile', 255);
            $table->enum('gender',['male','female']);
            $table->string('code_country', 50);
            $table->string('slug_country', 50);
            $table->integer('country_id');
            $table->string('city', 255);
            $table->text('bio');
            //بيانات الحساب البنكي
            $table->integer('bank_id')->nullable();
            $table->string('account_num')->nullable();
            $table->string('ipan')->nullable();
            //البيبال
            $table->string('paypal_email')->nullable();
            $table->enum('status',['pending','under_review','acceptable','unacceptable'])->default('pending');
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
        Schema::dropIfExists('request_join_marketers');
    }
}
