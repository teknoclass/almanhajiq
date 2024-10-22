<?php

use App\Models\UserPackages;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('private_lessons', function (Blueprint $table) {
            $table->dropColumn('is_package');
            $table->foreignIdFor(UserPackages::class , 'user_package_id')->after('meeting_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('private_lessons', function (Blueprint $table) {
            $table->dropForeignIdFor(UserPackages::class ,'user_package_id');
            $table->boolean('is_package')->default(false)->after('status');
        });
    }
};
