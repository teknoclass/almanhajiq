<?php

namespace App\Services;

use App\Repositories\PagesRepository;

class PagesService extends MainService
{
    public PagesRepository $pagesRepository;

    public function __construct(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    public function getPage($slug){
        $pages  = $this->pagesRepository->getPage($slug);
        if (!$pages) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }
        return $this->createResponse(
            __('message.success'),
            true,
            $pages
        );
    }

    public function about(){
        $about  = $this->pagesRepository->about();
        if (!$about) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }
        return $this->createResponse(
            __('message.success'),
            true,
            $about
        );
    }
}
