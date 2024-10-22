<?php

namespace App\Repositories\Front;

use App\Models\Pages;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForgotPasswordEloquent
{

    public function sendEmail($request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $user = User::where('email', $request->email)->first();

        $user->sendPasswordResetNotification($token);

        return [
            'message' => __('message.a_link_has_been_sent_to_your_inbox'),
            'status' => true
        ];
    }

    public function resetPassword($request)
    {

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->whereDate('created_at', '>=', (new Carbon)->subDays(1)->startOfDay()->toDateString())
            ->whereDate('created_at', '<=', (new Carbon)->now()->endOfDay()->toDateString())
            ->first();


        if (!$updatePassword) {
            return [
                'message' => __('message.invalid_token'),
                'status' => false
            ];
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();


        return [
            'message' => __('message.operation_accomplished_successfully'),
            'status' => true
        ];
    }
}
