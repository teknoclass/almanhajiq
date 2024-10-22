<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\StatisticsRequest;
use App\Repositories\Panel\StatisticsEloquent;


class StatisticsController extends Controller
{
    private $statistics;
    public function __construct(StatisticsEloquent $statistics_eloquent)
    {
        $this->middleware('auth:admin');

        $this->statistics = $statistics_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.statistics.all');
    }


    public function getDataTable()
    {
        return $this->statistics->getDataTable();
    }

    public function create()
    {

        return view('panel.statistics.create');
    }

    public function store(StatisticsRequest $request)
    {


        $response = $this->statistics->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->statistics->edit($id);


        return view('panel.statistics.create', $data);
    }

    public function update($id, StatisticsRequest $request)
    {
        $response = $this->statistics->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->statistics->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }
}
