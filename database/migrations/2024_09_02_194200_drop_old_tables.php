<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('course_curricula', function(Blueprint $table) {
            $table->dropColumn('item_id');
            $table->dropColumn('item_type');
            $table->nullableMorphs('itemable'); // Add morph columns if not already present

        });

        Schema::table('course_section_items', function(Blueprint $table) {
            $table->dropColumn('item_id');
            $table->dropColumn('item_type');
            $table->morphs('itemable');

        });

    }

    public function down(): void
    {
        Schema::table('course_curricula', function(Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->enum('item_type', ['lesson','quiz','assignment','section'])->index();

        });

        Schema::table('course_section_items', function(Blueprint $table) {
            $table->unsignedBigInteger('item_id');

            $table->enum('item_type', ['lesson', 'quiz', 'assignment'])
                  ->change();

        });
    }

};
