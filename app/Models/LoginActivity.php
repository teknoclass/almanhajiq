<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;

    const TYPE_LOGIN = 'login';

    const TYPE_LOGOUT = 'logout';

    const USER_TYPE_ADMIN = 'admin';

    const USER_TYPE_USER = 'user';


    protected $fillable = ['user_id', 'user_agent', 'ip_address', 'type', 'user_type'];

    protected $table = 'login_activities';

    public function user()
    {

        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function scopeFilter($q, $search)
    {
        return $q->whereHas('user', function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });
    }
}
