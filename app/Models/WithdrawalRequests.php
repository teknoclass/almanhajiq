<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequests extends Model
{
    use HasFactory;

    //status 'pending', 'underway','canceled','unacceptable','completed'
    const  PENDING = 'pending';

    const  CANCELED = 'canceled';

    const UNDERWAY = 'underway';

    const COMPLETED = 'completed';

    const UNACCEPRABEL = 'unacceptable';

    public const LECTURER='lecturer';

    public const MARKETER='marketer';

    //withdrawal_method 'cash', 'bank_transfer'
    protected $fillable = [
        'user_id','user_type','withdrawal_method', 'amount', 'details','status'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }


    public function scopeFilter($q, $search)
    {
        return $q->whereHas('user', function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%');
        });
    }

}
