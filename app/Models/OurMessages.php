<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class OurMessages extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected $fillable = ['image'];

    public $translatedAttributes  = ['title','description'];

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

    public function scopeFilter($q, $search)
    {
        return $q->whereHas('translations', function ($q) use ($search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });

    }

}
