<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends Controller
{

    public function getVideoLink($link)
    {

        $link=str_replace('-', '/', $link);

        $path = storage_path("app/uploads/files/videos/" . $link);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', "video/mp4");
        return $response;

    }

    public function getFileLink($link)
    {
        /*paths
            'users/{user_id}/job_proof_image'
            'users/{user_id}/id_image'
            'users/{user_id}/cv_file'

        */

        $link=str_replace('-', '/', $link);

        $path = storage_path("app/uploads/files/" . $link);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("CF-Cache-Status", 'HIF');
        $response->header("Cache-Control", 'max-age=604800, public');
        $response->header("Content-Type", $type);

        return $response;
    }

    public function uploadFiles(Request $request)
    {
        if ($request->file('file')) {
            $file=$request->file;

            $extension = $file->getClientOriginalExtension();
            $filename = 'file_'.time().mt_rand().'.'.$extension;

            $originalName = str_replace('.'.$extension, '', $file->getClientOriginalName());
            $file->move(storage_path() . '/app/uploads/files', $filename);


            return Response::json([
                'status' => true,
                'file_name' => $filename
            ], 200);
        }
    }




    public function uploadFile(Request $request)
    {
        if ($request->file('file')) {
            $file=$request->file;

            $extension = $file->getClientOriginalExtension();
            $filename = 'file_'.time().mt_rand().'.'.$extension;

            $originalName = str_replace('.'.$extension, '', $file->getClientOriginalName());
            $file->move(storage_path() . '/app/uploads/files', $filename);


            return Response::json([
                'status' => true,
                'file_name' => $filename
            ], 200);
        }
    }


    public function getCourseLessonItemLink($course_id, $lesson_type, $file)
    {
        $path = storage_path('app/uploads/files/courses/' . $course_id . '/' . $lesson_type . '/' . $file);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
    public function getCourseLessonItemLinkStream(Request $request , $course_id, $lesson_type, $file)
    {
        $path = storage_path('app/uploads/files/courses/' . $course_id . '/' . $lesson_type . '/' . $file);

        if (!File::exists($path)) {
            abort(404);
        }

        $fileSize = filesize($path);
        $start = 0;
        $end = $fileSize - 1;

        // Handle Range Requests
        if ($request->hasHeader('Range')) {
            preg_match('/bytes=(\d*)-(\d*)/', $request->header('Range'), $matches);

            $start = $matches[1] !== '' ? intval($matches[1]) : 0;
            $end = $matches[2] !== '' ? intval($matches[2]) : $fileSize - 1;
        }

        // Open file for reading
        $file = fopen($path, 'rb');
        fseek($file, $start);

        $response = new StreamedResponse(function () use ($file, $start, $end) {
            $bufferSize = 1024 * 8; // 8 KB buffer
            while (!feof($file) && ($pos = ftell($file)) <= $end) {
                echo fread($file, min($bufferSize, $end - $pos + 1));
                flush();
            }
            fclose($file);
        });

        // Set Headers
        $response->setStatusCode(206);
        $response->headers->set('Content-Type', 'video/mp4');
        $response->headers->set('Content-Length', $end - $start + 1);
        $response->headers->set('Accept-Ranges', 'bytes');
        $response->headers->set('Content-Range', "bytes $start-$end/$fileSize");

        return $response;
    }


}
