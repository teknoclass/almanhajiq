<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplateTexts extends Model
{
    use HasFactory;
     const COURSE_NAME_LOCATION='course_name_location';
     const LECTURER_NAME_LOCATION='lecturer_name_location';
     const STUDENT_NAME_LOCATION='student_name_location';
     const CERTIFICATE_DATE='certificate_date';
     const OTHERS='others';

    protected $fillable = ['certificate_template_id','text',
        'font_size_css','transform_css','font_color_css',
        'coordinates','type'];
}
