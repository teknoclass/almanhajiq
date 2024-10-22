<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Packages extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;
    public static $index = 0;

    protected $fillable = ['price','num_hours','type','color','num_months'];

    public $translatedAttributes = ['title', 'description'];

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

    public function getPrice()
    {
        $user = auth()->user();

        if($user && $user->country) {
            $price = ceil($user->country->currency_exchange_rate*$this->price) . " ".$user->country->currency_name;
        } else {
            $price = $this->price. ' ' . __('currency') . ' ';
        }
        return $price;

    }

    /**
     * Get all of the private_lessons for the Packages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
    */
    public function private_lessons(): HasManyThrough
    {
        return $this->hasManyThrough(PrivateLessons::class, UserPackages::class);
    }


    /**
     * Get all of the user_packages for the Packages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function user_packages(): HasMany
    {
        return $this->hasMany(UserPackages::class, 'package_id');
    }
}
