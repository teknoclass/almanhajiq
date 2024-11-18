<?php

namespace App\Http\Resources\Favourite;

use App\Http\Resources\BlogPostResource;
use App\Http\Resources\PostsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return new PostsResource($this->blog);
    }
}
