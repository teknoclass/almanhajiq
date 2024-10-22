<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketersTemplates extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['name','background','is_active'];


    public function texts()
    {
        return $this->hasMany('App\Models\MarketersTemplatesTexts', 'marketers_template_id', 'id');
    }

    public function scopeFilter($q, $search)
    {
        return $q->where('name', 'like', '%' . $search . '%');

    }
    public function scopeActive($q)
    {
        return $q->where('is_active', 1);

    }

}
