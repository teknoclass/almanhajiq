<?php

namespace App\Http\Controllers\Panel;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repositories\Panel\CategoryEloquent;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    private $category;
    public function __construct(CategoryEloquent $category_eloquent)
    {
        $this->middleware('auth:admin');

        $this->category = $category_eloquent;
    }


    public function index($parent)
    {
        $data = $this->category->index($parent);

        return view('panel.category.all', $data);
    }

    public function getDataTable($parent)
    {

        return $this->category->getDataTable($parent);
    }



    public function create($parent)
    {

        $data = $this->category->create($parent);


        return view('panel.category.create', $data);
    }

    public function edit($parent, $id)
    {
        $data = $this->category->edit($parent, $id);


        return  view('panel.category.create', $data);
    }


    public function store($parent, Request $request)
    {

        $response = $this->category->store($parent, $request);

        return $this->response_api($response['status'], $response['message']);
    }



    public function update($parent, $id, Request $request)
    {

        $response = $this->category->update($parent, $id, $request);

        return $this->response_api($response['status'], $response['message']);
    }



    public function delete($parent, $id)
    {
        $response = $this->category->delete($parent, $id);

        return $this->response_api($response['status'], $response['message']);
    }
}
