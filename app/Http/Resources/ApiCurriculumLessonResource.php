<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiCurriculumLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id;
        $data['storage'] = $this->storage;
        if($this->file_type == 'video' && $this->storage == 'upload'){
            $data['file'] = CourseVideoUrlStream($this->course_id , $this->file);
        }else if($this->file_type == 'doc'){
            $data['file'] = CourseDocUrl($this->course_id,$this->file);
        }else if($this->file_type == 'listen'){
            $data['file'] = CourseAudioUrl($this->course_id,$this->file);
        }else if($this->file_type == 'image'){
            $data['file'] = CourseImageUrl($this->course_id,$this->file);
        }else if($this->file_type == 'video' && $this->storage == 'vimeo_id'){
            $data['file'] = CourseVimeoUrl($this->file);
        }else{
            $data['file'] = $this->file;
        }
        $data['file_type'] = $this->file_type;
        $data['created_at'] = $this->created_at;
        $data['duration'] = $this->duration;
        $data['title'] = isset($this->translate(app()->getLocale())->title) ? $this->translate(app()->getLocale())->title : '';
        $data['description'] = isset($this->translate(app()->getLocale())->description) ? $this->translate(app()->getLocale())->description : '';
        $data['attachment'] = ApiLessonAttachmentResource::collection($this->attachments);
        $data['course_id'] = $this->course_id;
        $data['is_completed'] = $this->is_completed();
        return $data;

    }
}
