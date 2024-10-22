<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded=[];

    public $timestamps = false;

    protected $fillable = [
        'key', 'value'
    ];

    public function key($type)
    {
        return $this->where('key', $type)->first();
    }

    public function valueOf($type)
    {
        return (isset($this->key($type)->value)) ? $this->key($type)->value : '';
    }
}
