<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\OurTeamsEloquent;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\OurTeamsRequest;

class OurTeamsController extends Controller
{
    //
    private $our_team;
    public function __construct(OurTeamsEloquent $our_team_eloquent)
    {
        $this->middleware('auth:admin');

        $this->our_team = $our_team_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.our_teams.all');
    }

    public function getDataTable()
    {
        return $this->our_team->getDataTable();
    }

    public function create()
    {

        return view('panel.our_teams.create');
    }

    public function store(OurTeamsRequest $request)
    {


        $response = $this->our_team->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->our_team->edit($id);

        return view('panel.our_teams.create', $data);
    }

    public function update($id, OurTeamsRequest $request)
    {
        $response = $this->our_team->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->our_team->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
