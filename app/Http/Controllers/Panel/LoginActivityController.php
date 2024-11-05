<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\LoginActivityEloquent;
use App\Repositories\Panel\UsersEloquent;
use Illuminate\Http\Request;

class LoginActivityController extends Controller
{
    //
    private $login_activity;
    private $users;
    public function __construct(LoginActivityEloquent $login_activity_eloquent,UsersEloquent $users_eloquent)
    {
        $this->middleware('auth:admin');

        $this->login_activity = $login_activity_eloquent;
        $this->users = $users_eloquent;
    }


    public function index(Request $request) {

        $roles = $this->users->getAllRoles();
        $data['roles'] = $roles;
       return view('panel.login_activity.all',$data);
    }


    public function getDataTable()
    {
        return $this->login_activity->getDataTable();
    }

    public function delete($id)
    {
        $response = $this->login_activity->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
