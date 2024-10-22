<?php

namespace App\Logic;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Models\Image;
use Storage;
use Illuminate\Http\Request;

class ImageRepository
{
    private $full_save_path = 'app/uploads/images';
    private $save_path = 'uploads/images';

    public function upload($form_data, $type)
    {
        $validator = Validator::make($form_data, \App\Models\Image::$rules, \App\Models\Image::$messages);
        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
            ], 400);
        }
        $photo = $form_data['image'];
        $width = $form_data['width'];
        $height = $form_data['height'];

        $custome_path = '';

        if (isset($form_data['custome_path'])) {
            if ($form_data['custome_path']!='undefined') {
                $custome_path = $form_data['custome_path'];
            }
        }


        $extension = $photo->getClientOriginalExtension();
        $filename = 'image_'.time().mt_rand();
        $allowed_filename = $this->createUniqueFilename($filename, $extension, $custome_path);
        $uploadSuccess1 = $this->original($photo, $allowed_filename, $custome_path);
        $originalName = str_replace('.'.$extension, '', $photo->getClientOriginalName());

        if (!$uploadSuccess1) {
            return Response::json([
                'error' => true,
                'message' => 'Server error while uploading',
            ], 500);
        }
        $image = new Image();
        $image->display_name = $originalName.'.'.$extension;
        $image->file_name = $allowed_filename;
        $image->mime_type = $extension;
        $image->save();

        if ($custome_path!='') {
            $allowed_filename= $custome_path .'/'.$allowed_filename;
            $allowed_filename=str_replace('/', '-', $allowed_filename);
        }
        return Response::json([
            'status' => true,
            'file_name' => $allowed_filename,
            'id' => $image->id
        ], 200);
    }

    public function createUniqueFilename($filename, $extension, $custome_path='')
    {
        if ($custome_path=='') {
            $path = storage_path($this->full_save_path . $filename . '.' . $extension);
        } else {
            $full_path = $this->full_save_path . '/' . $custome_path .'/';
            $path = storage_path($full_path . $filename . '.' . $extension);
        }


        if (File::exists($path)) {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    /**
     * Optimize Original Image
     */
    public function original($photo, $filename, $custome_path='')
    {
        if ($custome_path=='') {
            $save_path = $this->save_path;
        } else {
            $save_path = $this->save_path . '/' . $custome_path ;
        }

        // dd($save_path);
        $image = $photo->storeAs($save_path, $filename);
        return $image;
    }
}
