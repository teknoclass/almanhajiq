<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactios extends Model
{
    use HasFactory;
    use SoftDeletes;

    //'deposit','withdrow'
    const WITHDROW = 'withdrow';
    const DEPOSIT = 'deposit';

    public const LECTURER='lecturer';

    public const MARKETER='marketer';

    public const STUDENT='student';

    protected $fillable = [
        'description','user_id','user_type', 'payment_id', 'amount','amount_before_discount', 'type','status',
        'transactionable_type', 'transactionable_id','brand','coupon','pay_transaction_id','is_paid'
    ];

    public function userX()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the user that owns the Transactios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter($q, $search)
    {
        return $q->where('brand', 'like', '%' . $search . '%');
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'payable')->orderBy('created_at' , 'desc');
    }


    // course
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    // parent transaction
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactios::class, 'pay_transaction_id');
    }

    public function related_transactions(): HasMany
    {
        return $this->hasMany(Transactios::class, 'pay_transaction_id');
    }

    public function related_balances(): HasMany
    {
        return $this->hasMany(Balances::class, 'pay_transaction_id');
    }

    public function related_userCourses(): HasMany
    {
        return $this->hasMany(UserCourse::class, 'pay_transaction_id');
    }

}
