<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Panel\SettingEloquent;

class SettingController extends Controller
{
    //

    private $setting;
    public function __construct(SettingEloquent $setting_eloquent)
    {
        $this->middleware('auth:admin');

        $this->setting = $setting_eloquent;
    }


    public function index()
    {

        $data = $this->setting->index();

        return view('panel.settings.edit', $data);
    }



    public function update(Request $request)
    {

        $response = $this->setting->update($request);

        return $this->response_api($response['status'], $response['message']);
    }
}
