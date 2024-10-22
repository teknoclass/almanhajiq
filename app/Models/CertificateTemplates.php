<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificateTemplates extends Model
{
    use HasFactory;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name','background','course_category_id','is_active','is_default'];


    public function texts()
    {
        return $this->hasMany('App\Models\CertificateTemplateTexts', 'certificate_template_id', 'id');
    }

    public function scopeFilter($q, $search)
    {
        return $q->where('name', 'like', '%' . $search . '%');

    }

}
