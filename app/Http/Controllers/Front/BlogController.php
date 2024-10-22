<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\BlogEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
{
    //

    private $blog;
    public function __construct(BlogEloquent $blog_eloquent)
    {

        $this->blog = $blog_eloquent;
    }

    public function index()
    {
        $data = $this->blog->index();

        return view('front.blog.index', $data);
    }

    public function posts(Request $request){

        $data = $this->blog->posts();

        if ($request->ajax())
        {
            return View::make('front.blog.posts.partials.all', $data)->render();
        }

        return view('front.blog.posts.index',$data);

    }

    public function news(Request $request){

        $data = $this->blog->news();

        if ($request->ajax())
        {
            return View::make('front.blog.news.partials.all', $data)->render();
        }

        return view('front.blog.news.index',$data);
    }


    public function singlePost($id)
    {
        $data = $this->blog->singlePost($id);

        return view('front.blog.single', $data);
    }

    public function categoryPosts(Request $request, $id)
    {

        $data = $this->blog->categoryPosts($id);

        if ($request->ajax())
        {
            return View::make('front.blog.posts.partials.all', $data)->render();
        }

        return view('front.blog.posts.index',$data);
    }
}
