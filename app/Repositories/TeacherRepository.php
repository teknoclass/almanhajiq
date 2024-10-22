<?php

namespace App\Repositories;

use App\Models\JoinAsTeacherRequests;
use App\Models\User;

class TeacherRepository
{
    public function getTeacherByEmail($email)
    {
        return User::where('email', $email)
                   ->where('role', User::LECTURER)
                   ->first();
    }

    public function createOrUpdateTeacherRequest($id, $data, $request)
    {
        return JoinAsTeacherRequests::updateOrCreate(['id' => $id], $data);
    }

}
