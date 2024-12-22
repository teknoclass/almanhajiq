<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balances extends Model
{
    use HasFactory;

    //'deposit','withdrow'
    const WITHDROW = 'withdrow';
    const DEPOSIT = 'deposit';

    public const LECTURER='lecturer';

    public const MARKETER='marketer';

    protected $fillable = [
        'description','user_id','user_type', 'transaction_id', 'transaction_type','amount',
        'system_commission','amount_before_commission'
        ,'type','is_retractable','becomes_retractable_at','pay_transaction_id','is_paid','payment_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the transaction that owns the UserCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactios::class, 'pay_transaction_id');
    }

}
