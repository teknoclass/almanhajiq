<?php

namespace App\Repositories\Panel;

use App\Models\Category;
use App\Models\Posts;
use App\Models\PostsComments;
use App\Models\User;
use DataTables;


class PostsCommentsEloquent
{
    public function getDataTable()
    {

        $data = PostsComments::select('id', 'text', 'post_id', 'is_published','user_id')
            ->with('post')
            ->with('user')
            ->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.posts_comments.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }



    public function edit($id)
    {
        $data['item'] = PostsComments::where('id', $id)->first();
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

        PostsComments::updateOrCreate(['id' => $id], $data);

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
        $item = PostsComments::find($id);
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

        $item = PostsComments::find($id);
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
