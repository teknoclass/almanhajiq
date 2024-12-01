<?php

namespace App\Repositories\Front\User;


class HelperEloquent
{

    public function getUser($is_web)
    {
        if ($is_web) {
            $user = auth('web')->user();
        } else {
            $user = auth('api')->user();
        }
        return $user;
    }

    function getType($is_web)
    {
        if($is_web)return 'web';
        else return 'api';
    }
}
