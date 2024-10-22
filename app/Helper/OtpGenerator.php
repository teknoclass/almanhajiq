<?php

namespace App\Helper;

class OtpGenerator
{
    public static function generateOtp(): string
    {
        return substr(sprintf("%06d", mt_rand(1, 999999)), 0, 6);
    }
}
