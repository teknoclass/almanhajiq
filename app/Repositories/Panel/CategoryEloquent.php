<?php

namespace App\Repositories\Panel;

use App\Models\Category;
use DataTables;
use Illuminate\Support\Facades\DB;

class CategoryEloquent
{
    public function index($parent)
    {
        $data['category'] = Category::query()->select('id', 'value', 'parent', 'key', 'title')
            ->with('translations:category_id,name,locale')->where('key', $parent)->first();

        return $data;
    }

    public function getDataTable($parent)
    {


        $parent = Category::select('id', 'value', 'parent', 'key')->where('key', $parent)->first();
        $data = Category::query()->select('id', 'value', 'parent', 'key')->where('parent', $parent->key)
            ->orderByDesc('created_at')->with(['translations:category_id,name,locale', 'parent'])->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.category.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create($parent)
    {
        $data['categories'] =
            Category::query()->select('id', 'value', 'parent', 'key')
                ->with('translations:category_id,name,locale')
                ->whereNull('parent')->get();

        $data['category'] = Category::query()->where('key', $parent)->first();

        return $data;
    }

    public function edit($parent, $id)
    {
        $data['item'] = Category::find($id);
        $data['category'] = Category::query()->where('key', $parent)->first();
        if (!$data['item']) {
            abort(404);
        }

        return $data;
    }


    public function store($parent, $request)
    {
        DB::beginTransaction();
        try {
            $parent = Category::select('id', 'key', 'parent', 'value')->where('key', $parent)->first();

            $request['parent'] = $parent->key;

            $value = Category::select('id', 'key', 'parent', 'value')->where('parent', $parent->key)->withTrashed()->max('value');

            $request['value'] = $value + 1;;

            Category::updateOrCreate(['id' => 0], $request->all())->createTranslation($request);

            DB::commit();
            $message = __('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();//=__('message_error');
            $status = false;
            DB::rollback();
        }

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function update($parent, $id, $request)
    {
        DB::beginTransaction();
        try {
            $parent = Category::select('id', 'key', 'parent', 'value')->where('key', $parent)->first();

            $request['parent'] = $parent->key;

            Category::updateOrCreate(['id' => $id], $request->all())->createTranslation($request);

            DB::commit();
            $message = __('message_done');
            $status = true;
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
        }

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function delete($parent, $id)
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
        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
