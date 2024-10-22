<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;

    protected $fillable = ['title','lang','is_default','is_rtl','can_delete'];



    public function scopeFilter($q, $search)
    {
        return $q->where('title', 'like', '%' . $search . '%');

    }
}
