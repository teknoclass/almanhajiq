<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\RatingsEloquent;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    //

    private $ratings;
    public function __construct(RatingsEloquent $ratings_eloquent)
    {

        $this->ratings = $ratings_eloquent;
    }

    public function add(Request $request)
    {

        $response = $this->ratings->add($request);

        return $this->response_api($response['status'], $response['message']);
    }


}
