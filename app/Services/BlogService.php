<?php

namespace App\Services;

use App\Repositories\BlogRepository;

class BlogService extends MainService
{
    public BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function latestPosts()
    {
        $posts = $this->blogRepository->latestPosts();
        if (!$posts) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $posts
        );
    }

    public function allPosts()
    {
        $posts = $this->blogRepository->all();
        if (!$posts) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $posts
        );
    }

    public function single($id)
    {
        $posts = $this->blogRepository->findById($id);
        if (!$posts) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $posts
        );
    }

    public function findByCategory($categoryId)
    {
        $posts = $this->blogRepository->findByCategoryId($categoryId);
        if (!$posts) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $posts
        );
    }

    public function blogCategories(){
        $categories = $this->blogRepository->blogCategories();
        if (!$categories) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $categories
        );
    }

}
