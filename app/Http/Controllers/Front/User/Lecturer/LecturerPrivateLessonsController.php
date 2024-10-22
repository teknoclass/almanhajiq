<?php

namespace App\Http\Controllers\Front\User\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\LecturerCategoryPricingRequest;
use App\Http\Requests\Front\User\LecturerPricingSettingRequest;
use App\Http\Requests\Front\User\LecturerPrivateLessonsSettingRequest;
use App\Http\Requests\Panel\PrivateLessonsRequest;
use App\Models\PrivateLessons;
use App\Repositories\Front\User\Lecturer\LecturerPrivateLessonsEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LecturerPrivateLessonsController extends Controller
{
    private $private_lessons;
    public function __construct(LecturerPrivateLessonsEloquent $private_lessons_eloquent)
    {
        $this->private_lessons = $private_lessons_eloquent;
    }

    public function index(Request $request, $type = 'upcoming')
    {
        $data = $this->private_lessons->index($type);

        if ($request->ajax()) {
            return View::make('front.user.lecturer.private_lessons.partials.all', $data)->render();
        }
        /*    echo \Carbon\Carbon::createFromFormat("H:i:s", date("H:i:s"));
            dd('fgfdf'); */
        return view('front.user.lecturer.private_lessons.index', $data);
    }

    public function filter(Request $request)
    {
        $data = $this->private_lessons->filters($request);

        return view('front.user.lecturer.private_lessons.index', $data);
    }

    public function settings()
    {
        $data = $this->private_lessons->settings();

        return view('front.user.lecturer.private_lessons.settings', $data);
    }

    public function create()
    {
        $data = $this->private_lessons->create();

        return view('front.user.lecturer.private_lessons.create', $data);
    }

    public function edit($id)
    {
        $data = $this->private_lessons->edit($id);

        return view('front.user.lecturer.private_lessons.create', $data);
    }

    public function set(PrivateLessonsRequest $request)
    {
        // return $request;
        $data = $this->private_lessons->set($request);

        return response()->json($data);
    }

    public function storeSettings(LecturerPrivateLessonsSettingRequest $request)
    {
        // return $request;
        $data = $this->private_lessons->storeSettings($request);

        return response()->json($data);
    }

    public function storeCategoriesPrices(LecturerCategoryPricingRequest $request)
    {
        // return $request;
        $data = $this->private_lessons->storeCategoriesPrices($request);
        return response()->json($data);
    }



    public function delete(Request $request)
    {
        $response = $this->private_lessons->delete($request);
        return $this->response_api($response['status'], $response['message']);
    }



    public function createMeeting($id)
    {
        $data = $this->private_lessons->createMeeting($id);

        if (!$data['status']) {
            return back()->withInput();
        } else if(env('MeetingChannel') == 'AGORA'){
            return redirect($data['url']);
        }else{
            return redirect($data['url']);
            return view('front.user.meeting.show_meeting', $data);
        }
    }

    public function joinMeeting($id)
    {
        $data = $this->private_lessons->joinMeeting($id);

        if (!$data['status']) {
            return back()->withInput();
        } else if(env('MeetingChannel') == 'AGORA'){
            return view('front.user.meeting.agora_meeting', $data);
        }else{
            return redirect($data['url']);
            return view('front.user.meeting.show_meeting', $data);
        }
    }

}
