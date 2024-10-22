<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $appends=['name'];

    protected $hidden=['mime_type','created_at','updated_at','deleted_at'];


    public function getFileNameAttribute($image)
    {
        return imageUrl($image);
    }

    public function getNameAttribute()
    {
        return $this->getOriginal('file_name');
    }

    public static $rules = [
        'image' => 'required|mimes:png,gif,jpeg,jpg,bmp,svg,ico,mp4'
    ];

    public static $messages = [
        'image.mimes' => 'الملف الذي تحاول رفعه له صيغة غير مدعومة',
        'image.required' => 'الصورة مطلوبة'
    ];
}
