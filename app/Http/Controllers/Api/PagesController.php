<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PagesResource;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\PagesService;
use Symfony\Component\HttpFoundation\Response;

class PagesController  extends Controller
{
    public PagesService $pagesService;

    public function __construct(PagesService $pagesService)
    {
        $this->pagesService = $pagesService;
    }

    public function findPage($slug){
        $pages =  $this->pagesService->getPage($slug);

            if (!$pages['status']) {
                $response = new ErrorResponse($pages['message'], Response::HTTP_BAD_REQUEST);

                return response()->error($response);
            }
            $collection                 = new PagesResource($pages['data']);
            $courses = new SuccessResponse($pages['message'],  $collection
                , Response::HTTP_OK);

            return response()->success($courses);

    }

    public function about(){
        $about =  $this->pagesService->about();
        if (!$about['status']) {
            $response = new ErrorResponse($about['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $collection                 = new PagesResource($about['data']);
        $courses = new SuccessResponse($about['message'],  $collection
            , Response::HTTP_OK);

        return response()->success($courses);

    }
}
