<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected $fillable = ['parent','number','value','image','currency_exchange_rate','parent_id','grade_sub_level_id'];

    public $translatedAttributes  = ['name','description','currency_name'];


    public function createTranslation(Request $request)
    {
        foreach (locales() as $key => $language) {
            foreach ($this->translatedAttributes as $attribute) {
                if ($request->get($attribute . '_' . $key) != null && !empty($request->$attribute . $key)) {
                    $this->{$attribute . ':' . $key} = $request->get($attribute . '_' . $key);
                }
            }
            $this->save();
        }
        return $this;
    }


    public function gradeLevels(): HasOne
    {
        return $this->hasOne(GradeLevel::class,'grade_level_id');
    }
    public static function children()
    {
        return self::query()->where('parent', '!=', 0);
    }
    public function getChildren()
    {
        return self::query()->where('parent', '=', $this->key);
    }

    public function getSubChildren(){
        return self::query()->where('parent_id', '=', $this->id)->get();

    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent')->withDefault();
    }

    public function scopeFilter($q, $search)
    {
        return $q->whereHas('translations', function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%');
        });

    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories', 'category_id', 'user_id');
    }

    public function scopeGetCategoriesByParent($query, $parent)
    {
        return $query->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->with('prices')
            ->where('parent', $parent)
            ->orderByDesc('created_at');
    }

    public function prices() {
        return $this->hasMany(CategoryPrice::class,'category_id' , 'value');
    }



}
