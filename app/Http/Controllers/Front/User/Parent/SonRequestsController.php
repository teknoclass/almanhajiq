<?php

namespace App\Http\Controllers\Front\User\Parent;

use App\Http\Controllers\Controller;
use App\Models\CourseAssignments;
use App\Models\CourseLessons;
use App\Models\CourseQuizzes;
use App\Models\Courses;
use App\Models\ParentSon;
use App\Models\User;
use App\Models\{CourseQuizzesResults,UserCourse,ParentSonRequest};
use App\Models\CourseAssignmentResults;
use App\Repositories\Front\User\AssignmentsEloquent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use DB;

class SonRequestsController extends Controller
{

    public function index()
    {
        $data['son_requests'] = ParentSonRequest::where('parent_id',getUser()->id)->get();
        
        return view('front.user.parent.sons-requests.index',$data);
    }

    public function update(Request $request,$id)
    {
        $parentRequest = ParentSonRequest::find($id);

        $linkSon = ParentSon::updateOrCreate([
            'son_id' => auth()->id(),
            'parent_id' => $parentRequest->parent_id,
        ],['status' => 'confirmed']);

        $parentRequest->update(['status' => 'confirmed']);

        $message = __('done_operation');

        return $this->response_api(true, $message);
    }
}