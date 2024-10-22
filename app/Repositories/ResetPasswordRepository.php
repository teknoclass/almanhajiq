<?php

namespace App\Repositories;

use App\Models\ResetPasswordOtp;
use Illuminate\Support\Carbon;

class ResetPasswordRepository
{
    public function create($user, $otp)
    {
        ResetPasswordOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    public function getByUserAndOtp($user, $otp)
    {
        return ResetPasswordOtp::where('user_id', $user->id)
                               ->where('otp', $otp)
                               ->where('otp_expires_at', '>', now())
                               ->first();

    }
}
