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
        if (Schema::hasColumn('certificate_template_texts', 'type')) {
            Schema::table('certificate_template_texts', function (Blueprint $table)
            {
                $table->dropColumn('type');
            });
        }

        if (!Schema::hasColumn('certificate_template_texts', 'type')) {
            Schema::table('certificate_template_texts', function (Blueprint $table) {
                $table->enum('type', ['course_name_location','lecturer_name_location','student_name_location','certificate_date','others'])->after('text')->dafault('others');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('certificate_template_texts', 'type')) {
            Schema::table('certificate_template_texts', function (Blueprint $table)
            {
                $table->dropColumn('type');
            });
        }
    }
};
