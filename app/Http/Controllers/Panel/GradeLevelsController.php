<?php

namespace App\Http\Controllers\Panel;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repositories\Panel\CategoryEloquent;
use Illuminate\Http\Request;
use DataTables;
use DB;

class GradeLevelsController extends Controller
{
    //
    private $category;
    public function __construct(CategoryEloquent $category_eloquent)
    {
        $this->middleware('auth:admin');

        $this->category = $category_eloquent;
    }


    public function index()
    {
        return view('panel.grade_levels.all');
    }

    public function getDataTable()
    { 
        $data = Category::query()->select('id', 'value', 'parent', 'key')->where('key','grade_levels')->whereNull('parent')
        ->with(['translations:category_id,name,locale', 'parent'])->orderBy('order','asc')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', 'panel.grade_levels.partials.actions')
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create()
    {

        $data['grade_levels'] =  Category::query()->select('id', 'value', 'parent', 'key')
            ->with('translations:category_id,name,locale')
            ->where('key','grade_levels')->get();


        return view('panel.grade_levels.create', $data);
    }

    public function edit($id)
    {
        $data['item'] = Category::find($id);

        return  view('panel.grade_levels.create', $data);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
        $request['parent'] = null;
        $request['key'] = "grade_levels";
        $request['value'] = Category::where('key','grade_levels')->whereNull('parent')->orderBy('id','desc')->first()->value + 1 ?? null;

      $category = Category::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);
      
        DB::commit();
        $message = __('message_done');
        $status = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        
        return $this->response_api($response['status'], $response['message']);
    }



    public function update($id, Request $request)
    {

        Category::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);
        $response = [
            'message' =>__('done_operation'),
            'status' => true,
        ];

        return $this->response_api($response['status'], $response['message']);
    }



    public function delete($id)
    {
        $item = Category::find($id);
        if ($item) {
            $item->delete();
            $message = __('delete_done');
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }

        return $this->response_api($response['status'], $response['message']);
    }
}
