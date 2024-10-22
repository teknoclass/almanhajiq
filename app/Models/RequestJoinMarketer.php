<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestJoinMarketer extends Model
{
    use HasFactory;

    
    public const PENDING = 'pending';

    public const ACCEPTABLE = 'acceptable';

    public const UNACCEPTABLE = 'unacceptable';

    protected $fillable = ['id','name','email','mobile','code_country','slug_country',
    'gender','country_id','city','bio','bank_id','account_num','ipan','paypal_email','status'];


    public function country()
    {
        return $this->hasOne('App\Models\Category', 'value', 'country_id')->where('parent', 'countries');
    }

    
    public function bank()
    {
        return $this->hasOne('App\Models\Category', 'value', 'bank_id')->where('parent', 'banks');
    }


    public function socialAccounts()
    {
        //SocialMediaRequestsMarketers
        return $this->hasMany('App\Models\SocialMediaRequestsMarketers', 'request_id', 'id');

    }


    public function scopeFilter($q, $search)
    {
        $country_id = $search['country_id'];
        $general_search = $search['general_search'];

        if ($country_id != '' && $country_id != null && $country_id != 'null') {
            $q = $q->where('country_id', $country_id);
        }
        if ($general_search != '' && $general_search != null && $general_search != 'null') {
            $q = $q->where('name', 'like', '%' . $general_search . '%')
            ->orWhere('email', 'like', '%' . $general_search . '%')
            ->orWhere('mobile', 'like', '%' . $general_search . '%')
            ;
        }
       
        return $q;
    }

}
