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
        Schema::table('course_section_items', function (Blueprint $table) {
            $table->enum('item_type', ['lesson', 'quiz', 'assignment', 'live_lesson'])
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_section_items', function (Blueprint $table) {
            $table->enum('item_type', ['lesson', 'quiz', 'assignment'])
                  ->change();
        });
    }
};
