<?php

namespace App\Http\Controllers\Front\User\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\LecturerEducationSettingRequest;
use App\Models\Category;
use App\Models\LecturerSetting;
use App\Repositories\Front\User\Lecturer\LecturerSettingsEloquent;
use Illuminate\Http\Request;

class LecturerSettingsController extends Controller
{

    private $lecturer_settings;
    public function __construct(LecturerSettingsEloquent $lecturer_settings_eloquent)
    {
        $this->lecturer_settings = $lecturer_settings_eloquent;
    }

    public function index($active_tab = 'main')
    {
        $data = $this->lecturer_settings->index($active_tab);

        // return $data;

        return view('front.user.lecturer.settings.index', $data);
    }



    public function update(LecturerEducationSettingRequest $request)
    {
        $data = $this->lecturer_settings->update($request);

        return response()->json($data);
    }

    public function setExperty(Request $request)
    {
        $data = $this->lecturer_settings->setExperty($request);

        return response()->json($data);
    }

    public function deleteExperty(Request $request)
    {
        $response = $this->lecturer_settings->deleteExperty($request);

        return response()->json($response);
    }

    public function setCategory(Request $request)
    {
        // return $request;
        $data = $this->lecturer_settings->setCategory($request);

        return response()->json($data);
    }

    public function deleteCategory(Request $request)
    {
        $response = $this->lecturer_settings->deleteCategory($request);

        return response()->json($response);
    }
}
