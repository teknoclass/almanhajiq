<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoginActivity;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
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
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        //
        if ($user instanceof  User) {
            $user_type = LoginActivity::USER_TYPE_USER;
        } else if ($user instanceof  Admin) {
            $user_type = LoginActivity::USER_TYPE_ADMIN;
        }
        if ($user) {
            LoginActivity::create([
                'user_id'       =>  @$user->id,
                'user_agent'    =>  \Illuminate\Support\Facades\Request::header('User-Agent'),
                'ip_address'    =>  \Illuminate\Support\Facades\Request::ip(),
                'type' => LoginActivity::TYPE_LOGOUT,
                'user_type' => @$user_type,
            ]);
        }
    }
}
