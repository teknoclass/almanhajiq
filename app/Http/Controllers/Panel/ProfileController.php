<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admins;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');


    }
    public function index()
    {

        $data['admin'] = auth()->user();

        return view("panel.profile.edit", $data);
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $data = $request->all();
        if (filled($request->new_password)) {

            $data['password'] = Hash::make($data['new_password']);

            unset($data['new_password'], $data['old_password']);
        }

        $admin->update($data);
        $message =__('message_done');
        return $this->response_api(true, $message);
    }
}
