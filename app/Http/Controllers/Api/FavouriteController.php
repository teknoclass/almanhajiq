<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Api\FavourtieEloquent;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    private $favourite;
    public function __construct(FavourtieEloquent $favourite_eloquent)
    {
        $this->favourite = $favourite_eloquent;
    }


    function set(Request $request)
    {
        $data = $this->favourite->toggle($request);
        $message = __('message.operation_accomplished_successfully');

        return $this->response_api(true,$message,$data);
    }
    function get(Request $request)
    {
        $data = $this->favourite->get($request,false);

        return $this->response_api($data['status'],$data['message'],$data['data']);
    }
}
