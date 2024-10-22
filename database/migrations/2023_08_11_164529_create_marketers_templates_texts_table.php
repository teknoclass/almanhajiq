<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketersTemplatesTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketers_templates_texts', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->unsignedInteger('marketers_template_id');
            $table->longText('text');
            $table->enum('type', ['coupon_code','others'])->default('others');
            $table->string('coordinates', 255);
            $table->string('font_size_css', 255)->nullable();
            $table->string('font_color_css', 255)->nullable();
            $table->string('transform_css', 255)->nullable();
            $table->foreign('marketers_template_id')->references('id')->on('marketers_templates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketers_templates_texts');
    }
}
