<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFaqs extends Model
{
    use HasFactory;

    public $fillable  = ['course_id', 'faq_id','is_active','order'];


    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function faq()
    {
        return $this->hasOne('App\Models\Faqs', 'id', 'faq_id');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) { // before delete() method call this
            $item->faq()->delete();
            // do the rest of the cleanup...
        });
    }
}
