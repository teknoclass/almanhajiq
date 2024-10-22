<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'category_type',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'value', 'category_id')
            ->where('parent', '=', $this->category_type);
    }


    public function scopeGetLecturerCategoriesByParent($query, $parent, $id)
    {
        return $query->where([['user_id',  $id]])
            ->whereHas('category', function ($query) use ($parent) {
                    $query->where('parent', $parent);
                })
            ->with(['category' => function ($query) {
                $query->select('id', 'title',)
                    ->with('translations:category_id,name,locale');
                }]);
    }
}
