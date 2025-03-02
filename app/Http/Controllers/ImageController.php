<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logic\ImageRepository;

class ImageController extends Controller
{
    //
    public function __construct(ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;
    }

    public function uploadImage() {

        $photo = \Input::all();
        $response = $this->image->upload($photo, 'image');
        return $response;
    }
}
