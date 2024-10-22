<?php

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
        Schema::create('join_as_teacher_requests', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->enum('gender', ['male', 'female']);
            $table->string('about');
            $table->unsignedBigInteger('specialization_id');
            $table->unsignedBigInteger('certificate_id');
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('country_id');
            $table->string('city');
            $table->enum('status', ['pending', 'acceptable', 'unacceptable'])->default('pending');
            $table->text('reason_unacceptable')->nullable();
            $table->string('id_image',255)->nullable();
            $table->string('job_proof_image',255)->nullable();
            $table->string('cv_file',255)->nullable();
            $table->foreign('specialization_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('certificate_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('join_as_teacher_requests');
    }
};
