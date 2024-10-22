<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoginActivity;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        if ($event->user instanceof  User) {
            $user_type = LoginActivity::USER_TYPE_USER;
        } else if ($event->user instanceof  Admin) {
            $user_type = LoginActivity::USER_TYPE_ADMIN;
        }
        LoginActivity::create([
            'user_id'       =>  $event->user->id,
            'user_agent'    =>  \Illuminate\Support\Facades\Request::header('User-Agent'),
            'ip_address'    =>  \Illuminate\Support\Facades\Request::ip(),
            'type' => LoginActivity::TYPE_LOGIN,
            'user_type' => $user_type,
        ]);
    }
}
