<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostsComments extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['text','is_published','post_id','user_id'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function post()
    {
        return $this->hasOne('App\Models\Posts', 'id', 'post_id');
    }
}
