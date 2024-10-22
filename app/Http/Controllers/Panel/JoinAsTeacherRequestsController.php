<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\JoinAsTeacherRequestsRequest;
use App\Repositories\Panel\JoinAsTeacherRequestsEloquent;

class JoinAsTeacherRequestsController extends Controller
{
    //

    private $join_as_teacher_requests;
    public function __construct(JoinAsTeacherRequestsEloquent $join_as_teacher_requests_eloquent)
    {
        $this->middleware('auth:admin');

        $this->join_as_teacher_requests = $join_as_teacher_requests_eloquent;
    }


    public function index(Request $request) {


        $data['competitions_programs'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'competitions_programs')
            ->orderByDesc('created_at')
            ->get();


        $data['countries'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'countries')
            ->orderByDesc('created_at')
            ->get();

        $data['joining_academic_certificates'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'joining_academic_certificates')
            ->orderByDesc('created_at')
            ->get();

        $data['joining_certificates'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'joining_certificates')
            ->orderByDesc('created_at')
            ->get();

        $data['experiences'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'joining_academic_experience')
            ->orderByDesc('created_at')
            ->get();

        $data['joining_sections'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'joining_sections')
            ->orderByDesc('created_at')
            ->get();

        $data['joining_dates'] = Category::query()->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'joining_academic_dates')
            ->orderByDesc('created_at')
            ->get();

       return view('panel.join_as_teacher_requests.all',$data);
    }


    public function getDataTable()
    {
        return $this->join_as_teacher_requests->getDataTable();
    }


    public function edit($id)
    {

        $data = $this->join_as_teacher_requests->edit($id);


        return view('panel.join_as_teacher_requests.view', $data);
    }

    public function update($id, Request $request)
    {

        $response = $this->join_as_teacher_requests->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->join_as_teacher_requests->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

}
