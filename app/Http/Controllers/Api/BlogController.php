<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\LatestPostsCollection;
use App\Http\Resources\BlogSliderCollection;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\AuthService;
use App\Services\BlogService;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    public function blog()
    {
        $latestPosts = $this->blogService->latestPosts();
        $slider = $this->blogService->latestPosts();
        $categories = $this->blogService->blogCategories();

        if (!$latestPosts['status']) {
            $response = new ErrorResponse($latestPosts['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        if (!$categories['status']) {
            $response = new ErrorResponse($categories['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $sliderCollection = new BlogSliderCollection($slider['data']);
        $latestPostsCollection = new LatestPostsCollection($latestPosts['data']);
        $categoriesCollection = new BlogCategoryCollection($categories['data']);
        $response = new SuccessResponse($latestPosts['message'], [
            $sliderCollection,
            $categoriesCollection,
            $latestPostsCollection
        ], Response::HTTP_OK);

        return response()->success($response);
    }
}
