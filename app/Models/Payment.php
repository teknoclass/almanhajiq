<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;
    protected $primary_key = 'id';

    protected $fillable = [
        "payable_id",
        "payable_type",
        "user_id",
        "payment_channel",
        "payment_method",
        "amount",
        "status",
        "operation_id",
        "response",
    ];
    protected $casts = [
        'response' => 'object',
    ];

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
