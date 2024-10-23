<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Posts;

class BlogRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new Posts());
    }
    public function latestPosts()
    {
        return $this->model::latest()
                    ->select('id', 'image', 'created_at', 'user_id','category_id')
                    ->with(['translations:posts_id,title,locale,text', 'user:id,name,image','category'])
                    ->take(4)->get();

    }

    public function blogCategories()
    {
        return Category::query()->select('id', 'value', 'image')
                       ->with('translations:category_id,name,locale')->where('parent', 'blog_categories')->get();
    }
}
