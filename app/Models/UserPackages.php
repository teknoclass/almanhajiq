<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UserPackages extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'price',
        'num_hours',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function package_valid()
    {
        $date = date('Y-m-d H:i:s');
        // ->whereHas('transaction' , function($payment){
        //     $payment->where('is_paid' , 1);
        // });
        return $this->belongsTo(Packages::class , 'package_id')
        ->whereRaw("DATE_ADD(packages.created_at, INTERVAL packages.num_months MONTH) > '$date'")
        ;
    }

    /**
     * Get all of the private_lessons for the UserPackages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function private_lessons(): HasMany
    {
        return $this->hasMany(PrivateLessons::class, 'user_package_id');
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transactios::class, 'transactionable')->orderBy('created_at' , 'desc');
    }

    function scopePaid($query) {
        return $query->whereHas('transaction' , function($payment){
            return $payment->where('is_paid' , 1);
        });
    }

    /**
     * Get all of the translations for the UserPackages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(PackagesTranslation::class, 'packages_id', 'package_id');
    }
}
