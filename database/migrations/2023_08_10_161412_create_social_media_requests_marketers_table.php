<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaRequestsMarketersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_requests_marketers', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->integer('socal_media_id');
            $table->string('link', 255);
            $table->string('num_followers', 255);
            $table->foreign('request_id')->references('id')->on('request_join_marketers')->onDelete('cascade');
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
        Schema::dropIfExists('social_media_requests_marketers');
    }
}
