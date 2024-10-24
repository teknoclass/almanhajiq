<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\BlogSliderCollection;
use App\Http\Resources\PostsResource;
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

    public function home()
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
        $latestPostsCollection = new PostsCollection($latestPosts['data']);
        $categoriesCollection = new BlogCategoryCollection($categories['data']);
        $response = new SuccessResponse($latestPosts['message'], [
            $sliderCollection,
            ['latest_posts'=>collect($categoriesCollection)],
            $latestPostsCollection
        ], Response::HTTP_OK);

        return response()->success($response);
    }

    public function single($id)
    {
        $post = $this->blogService->single($id);


        if (!$post['status']) {
            $response = new ErrorResponse($post['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $collection = new PostsResource($post['data']);
        $response = new SuccessResponse($post['message'], [
            $collection
        ], Response::HTTP_OK);

        return response()->success($response);
    }

    public function getByCategory($id)
    {
        $posts = $this->blogService->findByCategory($id);

        if (!$posts['status']) {
            $response = new ErrorResponse($posts['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $collection = new PostsCollection($posts['data']);
        $response = new SuccessResponse($posts['message'], [
            $collection
        ], Response::HTTP_OK);

        return response()->success($response);
    }

    public function posts()
    {
        $posts = $this->blogService->allPosts();

        if (!$posts['status']) {
            $response = new ErrorResponse($posts['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $collection = new PostsCollection($posts['data']);
        $response = new SuccessResponse($posts['message'], [
            $collection
        ], Response::HTTP_OK);

        return response()->success($response);
    }
}
