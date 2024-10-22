<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\HomePageSettings;
use App\Repositories\Panel\HomePageSectionsEloquent;
use Illuminate\Http\Request;

class HomePageSectionsController extends Controller
{
    //

    private $home_page_sections;
    public function __construct(HomePageSectionsEloquent $home_page_sections_eloquent)
    {
        $this->middleware('auth:admin');

        $this->home_page_sections = $home_page_sections_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.home_page_sections.all');
    }


    public function getDataTable()
    {
        return $this->home_page_sections->getDataTable();
    }

    public function indexOrders(Request $request)
    {
        $sections=HomePageSettings::orderBy('order_num', 'asc')->get();

        $data['sections']=$sections;


        return view('panel.home_page_sections.orders', $data);

    }

    public function storeOrders(Request $request)
    {
        $response = $this->home_page_sections->storeOrders($request);
        return $this->response_api($response['status'], $response['message']);


    }

    public function operation(Request $request)
    {
        $response = $this->home_page_sections->operation($request);
        return $this->response_api($response['status'], $response['message']);
    }


}
