<?php

namespace App\Repositories\Front\User\Marketer;

use App\Models\User;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class CustomersEloquent extends HelperEloquent
{
    public function all($request, $is_web = true, $count_itmes = 9)
    {
        $data['user'] = $this->getUser($is_web);

        $data['customers']=User::where('market_id', $data['user']->id);

        $data['customers'] = $data['customers']->paginate($count_itmes);

        return $data;


    }

}
