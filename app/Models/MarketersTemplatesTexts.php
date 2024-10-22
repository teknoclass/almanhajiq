<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketersTemplatesTexts extends Model
{
    use HasFactory;

       //type : 'coupon_code','others'


       public const COUPON_CODE='coupon_code';
       public const OTHERS='others';
   
       protected $fillable = ['marketers_template_id','text',
       'font_size_css','transform_css','font_color_css',
      'coordinates','type'];

}
