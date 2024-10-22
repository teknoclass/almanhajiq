<?php

namespace App\Repositories\Front;


class HelperEloquent
{

    public function getUser($is_web)
    {
        if ($is_web) {
            $user = auth('web')->user();
        } else {
            $user = auth()->user();
        }
        return $user;
    }
}
