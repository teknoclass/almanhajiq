<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class FileUploadService
{
    public static function handleFileUpload($data,$request, $courseId, $fileType, $type)
    {
        $filename = null;

        switch ($fileType) {
            case 'video':
                $filename = ($type == 'upload')
                    ? uploadvideo($request->file('upload'), 'courses/' . $courseId . '/videos')
                    : $request->{$data['video_type']};
                break;
            case 'listen':
                $filename = uploadVoice($request->file('listen'), 'courses/' . $courseId . '/listen');
                break;
            case 'text':
                $filename = $data['text'];
                break;
            case 'image':
                $filename = $request->file('image') ? str_replace('/', '-', uploadFile($request->file('image'), 'courses/' . $courseId . '/images')) : "";
                break;
            case 'doc':
                $file  = $request->{$data['doc_type']};
                Log::error($request);
                if ($file->isValid()) {
                    $filename = $file->getClientOriginalName();
                    $file->move(storage_path() . '/app/uploads/files/courses/' . $courseId . '/docs', $filename);
                }
                else {
                    throw new \Exception("File upload failed");
                }
                break;
        }
        return $filename;
    }
}
