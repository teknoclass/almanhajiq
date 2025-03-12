<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;


class CourseSections extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected     $fillable = ['id', 'is_active', 'course_curriculum_id','course_id'];

    public $translatedAttributes = ['title'];

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

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    function can_delete()
    {
        foreach ($this->items as $section_item)
        {
            if($section_item->item && $section_item->item?->can_delete()){
                return false;
            }
        }
        return true;
    }

    public function courseCurriculum(): BelongsTo
    {
        return $this->belongsTo(CourseCurriculum::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CourseSectionItems::class)->whereHas('itemable',function($q){
            $q->whereNull('deleted_at');
        });
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class,'course_id');
    }
}
