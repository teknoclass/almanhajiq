<?php

namespace App\Repositories;

use App\Models\User;

class StudentRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

}
