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

    public function all()
    {
        return $this->model::
                    select('id', 'image', 'created_at', 'user_id','category_id')
                    ->with(['translations:posts_id,title,locale,text', 'user:id,name,image','category'])
                    ->paginate();

    }

    public function findByCategoryId(int $categoryId){
        return $this->model::
        select('id', 'image', 'created_at', 'user_id','category_id')
                           ->with(['translations:posts_id,title,locale,text', 'user:id,name,image','category'])
                           ->where('category_id',$categoryId)
                           ->paginate();
    }

    public function findById($id)
    {
        return $this->model::
                    select('id', 'image', 'created_at', 'user_id','category_id')
                    ->with(['translations:posts_id,title,locale,text', 'user:id,name,image','category'])
                    ->where('id',$id)
                    ->first();

    }

    public function blogCategories()
    {
        return   Category::getCategoriesByParent('blog_categories')->get();

    }
}
