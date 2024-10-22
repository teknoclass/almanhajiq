<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function updateOrCreateUser($data)
    {
        $user = User::updateOrCreate(['id' => 0], $data);
        $user->update();

        return $user;
    }

    public function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();

    }
}
