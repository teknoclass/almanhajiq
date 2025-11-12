<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = 'course_assignment_questions_translations';

        // Get all indexes for the table
        $indexes = DB::connection()->getDoctrineSchemaManager()
            ->listTableIndexes($tableName);

        // Drop indexes on 'title' column if they exist
        Schema::table($tableName, function (Blueprint $table) use ($indexes) {
            foreach ($indexes as $index) {
                $columns = $index->getColumns();

                // Check if 'title' is in the index columns
                if (in_array('title', $columns)) {
                    $indexName = $index->getName();

                    // Check if it's a unique index
                    if ($index->isUnique()) {
                        $table->dropUnique($indexName);
                    } else {
                        $table->dropIndex($indexName);
                    }
                }
            }
        });

        // Change the column to LONGTEXT
        DB::statement('ALTER TABLE course_assignment_questions_translations MODIFY title LONGTEXT NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE course_assignment_questions_translations MODIFY title VARCHAR(255) NOT NULL');
    }
};
