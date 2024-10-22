<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\UserCompetition;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

class ImageHandlerController
{
    public function getPublicImage($size, $id)
    {
        /*paths
            'users/{user_id}/image'


        */

        $id=str_replace('-', '/', $id);
        $path = storage_path('app/uploads/images/'.$id);

        if (!File::exists($path)) {
            $path = storage_path('app/uploads/images/default_image.png');
        }

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $sizes = explode("x", $size);

        if (is_numeric($sizes[0]) && is_numeric($sizes[1])) {
            $manager = new ImageManager();
            $image = $manager->make($file)->fit($sizes[0], $sizes[1], function ($constraint) {
                $constraint->upsize();
            });

            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
            $response->header("Content-Type", $type);

            return $response;
        } else {
            abort(404);
        }
    }


    public function getImageResize($size, $id)
    {
        /*paths
            'users/{user_id}/image'


        */

        $id=str_replace('-', '/', $id);

        $path = storage_path('app/uploads/images/'.$id);

        if (!File::exists($path)) {
            $path = storage_path('app/uploads/images/default_image.jpg');
        }

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        if (is_numeric($size)) {
            $manager = new ImageManager();
            $image = $manager->make($file);
            $height = $image->height();
            $width = $image->width();
            if ($width > $height) {
                $new_height = (($height * $size)/$width);
                $image = $image->resize($size, $new_height, function ($constraint) {
                    $constraint->upsize();
                });
            } else {
                $new_width = (($width * $size)/$height);
                $image = $image->resize($new_width, $size, function ($constraint) {
                    $constraint->upsize();
                });
            }

            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
            $response->header("Content-Type", $type);

            return $response;
        } else {
            abort(404);
        }
    }

    public function getDefaultImage($id)
    {
        /*paths
            'users/{user_id}/image'


        */

        $id=str_replace('-', '/', $id);

        $path = storage_path('app/uploads/images/'.$id);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);


        if ($type!='image/svg') {
            $manager = new ImageManager();
            $image = $manager->make($file);

            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
//            $response->header("Content-Encoding", 'gzip');
            $response->header("Content-Type", $type);
//            $response->header("Vary", 'Accept-Encoding');
            return $response;
        } else {
            return response([$file], 200);
        }
    }

    public function getCertificateImage($id)
    {
        $item=UserCompetition::find($id);
        $student_ownership_check=true;

        if (auth('admin')->check()) {
            $student_ownership_check=false;
        }

        if ($student_ownership_check) {
            if (auth('web')->check()) {
                if (@$item->user_id !=auth('web')->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        $path = storage_path('app/certificates/'.@$item->user_id.'/'.$item->certificate);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);


        if ($type!='image/svg') {
            $manager = new ImageManager();
            $image = $manager->make($file);

            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
            $response->header("Content-Type", $type);
            return $response;
        } else {
            return response([$file], 200);
        }
    }

    public function getCenterCertificateImage($id)
    {
        $item=UserCompetition::find($id);
        $student_ownership_check=true;

        if (auth('admin')->check()) {
            $student_ownership_check=false;
        }

        if ($student_ownership_check) {
            if (auth('web')->check()) {
                if (@$item->user_id !=auth('web')->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        $path = storage_path('app/center-certificates/'.@$item->user_id.'/'.$item->center_certificate);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);


        if ($type!='image/svg') {
            $manager = new ImageManager();
            $image = $manager->make($file);

            $response = Response::make($image->encode($image->mime), 200);

            $response->header("CF-Cache-Status", 'HIF');
            $response->header("Cache-Control", 'max-age=604800, public');
            $response->header("Content-Type", $type);
            return $response;
        } else {
            return response([$file], 200);
        }
    }
}
