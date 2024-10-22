<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\OurPartnersEloquent;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\OurPartnersRequest;

class OurPartnersController extends Controller
{
    //
    private $our_partner;
    public function __construct(OurPartnersEloquent $our_partner_eloquent)
    {
        $this->middleware('auth:admin');

        $this->our_partner = $our_partner_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.our_partners.all');
    }

    public function getDataTable()
    {
        return $this->our_partner->getDataTable();
    }

    public function create()
    {

        return view('panel.our_partners.create');
    }

    public function store(OurPartnersRequest $request)
    {


        $response = $this->our_partner->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->our_partner->edit($id);

        return view('panel.our_partners.create', $data);
    }

    public function update($id, OurPartnersRequest $request)
    {
        $response = $this->our_partner->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->our_partner->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
