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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile', 255)->nullable();
            $table->string('code_country',50)->nullable();
            $table->string('slug_country',50)->nullable();
            $table->string('password');
            $table->string('password_c', 255)->nullable();
            $table->boolean('is_block')->default(0);
            $table->enum('role',['student','lecturer'])->default('student');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('image',255)->default('avatar.png');
            $table->date('dob')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('trainer_name', 255)->nullable();
            $table->string('validation_code', 255)->nullable();
            $table->date('validation_at')->nullable();
            $table->boolean('is_validation')->default(0);
            $table->timestamp('last_send_validation_code')->nullable();
            $table->integer('try_num_validation')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->longText('device_token',)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
