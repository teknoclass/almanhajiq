<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinAsTeacherRequests extends Model
{
    use HasFactory;


     const PENDING = 'pending';

     const ACCEPTABLE = 'acceptable';

     const UNACCEPTABLE = 'unacceptable';

    protected $guarded = ['id'];

    public function country()
    {
        return $this->hasOne('App\Models\Category', 'value', 'country_id')->where('parent', 'countries');
    }

    public function certificate()
    {
        return $this->hasOne('App\Models\Category', 'value', 'certificate_id')->where('parent', 'joining_certificates');
    }

    public function specialization()
    {
        return $this->hasOne('App\Models\Category', 'value', 'specialization_id')->where('parent', 'joining_sections');
    }

    public function material()
    {
        return $this->hasOne('App\Models\Category', 'value', 'material_id')->where('parent', 'joining_course');
    }

    public function scopeFilter($q, $search)
    {
        $country_id = $search['country_id'];
        $specialization_id = $search['specialization_id'];
        $certificate_id = $search['certificate_id'];
        $material_id = $search['material_id'];
        
        if ($country_id != '' && $country_id != null && $country_id != 'null') {
            $q = $q->where('country_id', $country_id);
        }
        if ($specialization_id != '' && $specialization_id != null && $specialization_id != 'null') {
            $q = $q->where('specialization_id', $specialization_id);
        }
        if ($certificate_id != '' && $certificate_id != null && $certificate_id != 'null') {
            $q = $q->where('certificate_id', $certificate_id);
        }
        if ($material_id != '' && $material_id != null && $material_id != 'null') {
            $q = $q->where('material_id', $material_id);
        }
        return $q;
    }
}
