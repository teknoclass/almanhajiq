<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\RoleRequest;
use App\Repositories\Panel\RolesEloquent;

class RolesController extends Controller
{
    //
    private $roles;
    public function __construct(RolesEloquent $roles_eloquent)
    {
        $this->middleware('auth:admin');

        $this->roles = $roles_eloquent;
    }

    public function index(Request $request)
    {

        return view('panel.roles.all');
    }

    public function getDataTable()
    {

        return $this->roles->getDataTable();
    }

    public function create()
    {

        return view('panel.roles.create');
    }

    public function store(RoleRequest $request)
    {

        $response = $this->roles->store($request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function edit($id)
    {

        $data = $this->roles->edit($id);

        return view('panel.roles.create', $data);
    }

    public function update($id, RoleRequest $request)
    {
        $response = $this->roles->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function delete($id)
    {
        $response = $this->roles->delete($id);

        return $this->response_api($response['status'], $response['message']);
    }
}
