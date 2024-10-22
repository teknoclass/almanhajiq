<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title','text','tags','seo_title','seo_desc','sec_keyword','sec_alt'];

}
