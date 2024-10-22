<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Posts;

class BlogEloquent
{

    public function index()
    {
        $data['slider_posts'] = Posts::latest()
        ->select('id', 'image','created_at','user_id','category_id')
        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
        ->take(4)->get();

        $data['categories'] =Category::query()->select('id', 'value','image')
        ->with('translations:category_id,name,locale')->where('parent', 'blog_categories')->get();

        $data['latest_posts'] = Posts::latest()
        ->select('id', 'image','created_at','user_id','category_id')
        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
        ->take(4)->get();

        if ($data['slider_posts'] == '' || $data['latest_posts'] == '' ) {
            abort(404);
        }

        return $data;
    }


    public function posts()
    {
        $data['posts'] = Posts::latest()
        ->select('id', 'image','user_id','created_at','category_id')
        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
        ->paginate(12);

        return $data;
    }

    public function news()
    {
        $data['news'] = Posts::latest()
        ->select('id', 'image','created_at')
        ->with('translations:posts_id,title,locale,text')
        ->paginate(12);

        return $data;
    }

    public function singlePost($id)
    {
        $data['post'] = Posts::where('id', $id)
        ->select('id', 'image','created_at','user_id','category_id')
        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
        ->first();

        $data['related_posts'] = Posts::where('id', '!=', $id)->latest()
        ->select('id', 'image','created_at','user_id','category_id')
        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
        ->take(4)->get();

        if ($data['post'] == '' || $data['related_posts'] == '' ) {
            abort(404);
        }

        return $data;
    }

    public function categoryPosts($id)
    {
        $data['posts'] = Posts::latest()
        ->select('id', 'image','created_at','user_id','category_id')
        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
        ->where('category_id', $id)
        ->paginate(12);

        return $data;
    }
}
