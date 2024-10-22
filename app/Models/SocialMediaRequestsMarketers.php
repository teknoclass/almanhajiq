<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaRequestsMarketers extends Model
{
    use HasFactory;

    protected $fillable = ['id','request_id','socal_media_id','link','num_followers'];

    public function socalMedia(){

        return $this->hasOne('App\Models\Category', 'value', 'socal_media_id')
        ->where('parent', 'social_media_items');

    }


}
