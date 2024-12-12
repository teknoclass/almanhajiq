<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentSonRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "parent_id",
        "son_id",
        "status"
    ];

    public function parent()
    {
        return $this->belongsTo(User::class,'parent_id','id');
    }

    public function son()
    {
        return $this->belongsTo(User::class,'son_id','id');
    }
}
