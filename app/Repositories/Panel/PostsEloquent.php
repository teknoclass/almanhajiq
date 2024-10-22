<?php

namespace App\Repositories\Panel;

use App\Models\Category;
use App\Models\Posts;
use App\Models\User;
use DataTables;


class PostsEloquent
{
    public function getDataTable()
    {

        $data = Posts::select('id', 'category_id', 'num_views', 'date_publication', 'is_published','user_id')
            ->with('translations:posts_id,title,locale')
            ->with('category')
            ->with('user')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.posts.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $data['blog_categories'] = Category::query()->where('parent', 'blog_categories')
            ->orderByDesc('created_at')->get();
        $data['users'] = User::query()->orderByDesc('created_at')->get();
        return $data;
    }


    public function store($request)
    {


        $data = $request->all();
        $data['date_publication'] = date("Y-m-d", strtotime($request->get('date_publication')));

        Posts::updateOrCreate(['id' => 0], $data)->createTranslation($request);

        $message = __('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {
        $data['item'] = Posts::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        $data['blog_categories'] = Category::query()->where('parent', 'blog_categories')
            ->orderByDesc('created_at')->get();
        $data['users'] = User::query()->orderByDesc('created_at')->get();

        return $data;
    }

    public function update($id, $request)
    {

        $data = $request->all();
        $data['date_publication'] = date("Y-m-d", strtotime($request->get('date_publication')));

        // dd($request->text_ar);

        Posts::updateOrCreate(['id' => $id], $data)->createTranslation($request);

        $message = __('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function delete($id)
    {
        $item = Posts::find($id);
        if ($item) {
            $item->delete();
            $message =__('delete_done');
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

    public function operation($request)
    {
        $id = $request->get('id');

        $item = Posts::find($id);
        if ($item) {
            $item->is_published = !$item->is_published;
            $item->update();
            $message = __('message_done');
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
