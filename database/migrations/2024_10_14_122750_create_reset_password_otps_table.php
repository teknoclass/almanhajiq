<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reset_password_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('otp');
            $table->timestamp('otp_expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reset_password_otps');
    }
};
