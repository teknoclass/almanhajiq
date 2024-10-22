<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\LanguagesEloquent;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\LanguagesRequest;

class LanguagesController extends Controller
{
    //

    private $languages;
    public function __construct(LanguagesEloquent $languages_eloquent)
    {
        $this->middleware('auth:admin');

        $this->languages = $languages_eloquent;
    }


    public function index(Request $request) {

       return view('panel.languages.all');
    }


    public function getDataTable()
    {
        return $this->languages->getDataTable();
    }

    public function create()
    {

        return view('panel.languages.create');
    }

    public function store(LanguagesRequest $request)
    {


        $response = $this->languages->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->languages->edit($id);


        return view('panel.languages.create', $data);
    }

    public function update($id, LanguagesRequest $request)
    {
        $response = $this->languages->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->languages->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }


}
