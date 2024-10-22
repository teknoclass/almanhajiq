<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    protected $guard = 'admin';

    protected $fillable=['name','email','password','device_token'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeFilter($q, $search) {
        return $q->where('name', 'like', '%' . $search . '%')
            ->orWhere('email','like', '%' . $search . '%')->where('id','!=',1);
    }
}
