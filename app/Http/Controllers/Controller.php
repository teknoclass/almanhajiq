<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function response_api($status, $message, $items = null, $redirect_url=null)
    {
        $response = ['status' => $status, 'message' => $message];
        if ($status && isset($items)) {
            $response['item'] = $items;
        } else {
            $response['errors_object'] = $items;
        }
        if ($redirect_url) {
            $response['redirect_url']=$redirect_url;
        }
        return response()->json($response);
    }
}
