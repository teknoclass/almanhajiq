<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('grade_level_id')->nullable()->after('category_id');

            $table->foreign('grade_level_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('grade_sub_level')->nullable()->after('category_id');

            $table->foreign('grade_sub_level')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['grade_sub_level']);
            $table->dropColumn('grade_sub_level');
            $table->dropForeign(['grade_level_id']);
            $table->dropColumn('grade_level_id');
        });
    }
};
