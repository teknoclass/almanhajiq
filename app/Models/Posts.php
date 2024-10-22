<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Posts extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected $fillable = ['image','category_id','is_published','date_publication','user_id'];

    protected $translatedAttributes = ['title','text','tags','seo_title','seo_desc','sec_keyword','sec_alt'];

    public function createTranslation(Request $request)
    {
        foreach (locales() as $key => $language) {
            foreach ($this->translatedAttributes as $attribute) {
                if ($request->get($attribute . '_' . $key) != null
                    && !empty($request->$attribute . $key)) {
                    $this->{$attribute . ':' . $key} = $request->get($attribute . '_' . $key);
                }
            }
            $this->save();
        }
        return $this;
    }


    public function scopeFilter($q, $search)
    {
        return $q->whereHas('translations', function ($q) use ($search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'value', 'category_id')
            ->where('parent', 'blog_categories');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
