<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\PostsRequest;
use App\Repositories\Panel\PostsEloquent;

class PostsController extends Controller
{
    //

    private $posts;

    public function __construct(PostsEloquent $posts_eloquent)
    {
        $this->middleware('auth:admin');

        $this->posts = $posts_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.posts.all');
    }


    public function getDataTable()
    {
        return $this->posts->getDataTable();
    }

    public function create()
    {

        $data = $this->posts->create();

        return view('panel.posts.create', $data);
    }

    public function store(PostsRequest $request)
    {


        $response = $this->posts->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->posts->edit($id);


        return view('panel.posts.create', $data);
    }

    public function update($id, PostsRequest $request)
    {
        $response = $this->posts->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->posts->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->posts->operation($request);
        return $this->response_api($response['status'], $response['message']);


    }


}
