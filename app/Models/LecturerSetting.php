<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class LecturerSetting extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'user_id',
        'video_thumbnail',
        'video_type',
        'video',
        'exp_years',
        'twitter',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
        'major_id',
        'bank_id',
        'account_num',
        'name_in_bank',
        'iban',
    ];

    public $translatedAttributes  = ['abstract','description', 'position'];


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


    public function major()
    {
        return $this->hasOne('App\Models\Category', 'value', 'major_id')->where('parent', 'joining_sections');
    }
    public function bank()
    {
        return $this->hasOne(Category::class, 'value', 'bank_id')->where('parent', 'banks');
    }

    public function getGroupMinStudentNo($mode, $isGroup)
    {
        if ($mode === 'online') {
            $minKey = $isGroup ? 'online_group_min_no' : null;
        } else {
            $minKey = $isGroup ? 'offline_group_min_no' : null;
        }

        return $minKey ? $this->$minKey : null;
    }

    public function getGroupMaxStudentNo($mode, $isGroup)
    {
        if ($mode === 'online') {
            $maxKey = $isGroup ? 'online_group_max_no' : null;
        } else {
            $maxKey = $isGroup ? 'offline_group_max_no' : null;
        }

        return $maxKey ? $this->$maxKey : null;
    }

    public function getDiscount($mode, $isGroup)
    {
        if ($mode === 'online') {
            $discountKey = $isGroup ? null : 'online_discount';
        } else {
            $discountKey = $isGroup ? null : 'offline_discount';
        }

        return $discountKey ? $this->$discountKey : null;
    }

}
