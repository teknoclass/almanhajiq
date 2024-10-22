<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\PostsCommentsRequest;
use App\Repositories\Panel\PostsCommentsEloquent;

class PostsCommentsController extends Controller
{
    //

    private $posts_comments;

    public function __construct(PostsCommentsEloquent $posts_comments_eloquent)
    {
        $this->middleware('auth:admin');

        $this->posts_comments = $posts_comments_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.posts_comments.all');
    }


    public function getDataTable()
    {
        return $this->posts_comments->getDataTable();
    }

    public function create()
    {

        $data = $this->posts_comments->create();

        return view('panel.posts_comments.create', $data);
    }

    public function store(PostsCommentsRequest $request)
    {


        $response = $this->posts_comments->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->posts_comments->edit($id);


        return view('panel.posts_comments.create', $data);
    }

    public function update($id, PostsCommentsRequest $request)
    {
        $response = $this->posts_comments->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->posts_comments->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->posts_comments->operation($request);
        return $this->response_api($response['status'], $response['message']);


    }


}
