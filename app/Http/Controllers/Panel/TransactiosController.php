<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\TransactiosEloquent;
use Illuminate\Http\Request;

class TransactiosController extends Controller
{
    //

    private $transactios;
    public function __construct(TransactiosEloquent $transactios_eloquent)
    {
        $this->middleware('auth:admin');

        $this->transactios = $transactios_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.transactios.all');
    }


    public function getDataTable()
    {
        return $this->transactios->getDataTable();
    }

    public function delete($id)
    {
        $response = $this->transactios->delete($id);
        
        return $this->response_api($response['status'], $response['message']);
    }

}
