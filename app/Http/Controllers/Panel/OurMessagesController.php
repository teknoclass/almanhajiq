<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\OurMessagesRequest;
use App\Repositories\Panel\OurMessagesEloquent;

class OurMessagesController extends Controller
{
    //

    private $our_messages;
    public function __construct(OurMessagesEloquent $our_messages_eloquent)
    {
        $this->middleware('auth:admin');

        $this->our_messages = $our_messages_eloquent;
    }

    public function index(Request $request)
    {

        return view('panel.our_messages.all');
    }

    public function getDataTable()
    {
        return $this->our_messages->getDataTable();
    }

    public function create()
    {

        return view('panel.our_messages.create');
    }

    public function store(OurMessagesRequest $request)
    {


        $response = $this->our_messages->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->our_messages->edit($id);


        return view('panel.our_messages.create', $data);
    }

    public function update($id, OurMessagesRequest $request)
    {
        $response = $this->our_messages->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->our_messages->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }


}
