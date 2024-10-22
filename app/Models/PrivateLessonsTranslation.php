<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivateLessonsTranslation extends Model
{

    use HasFactory;
    public $fillable  = ['title', 'description'];


    /**
     * Get the lesson that owns the PrivateLessonsTranslation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(PrivateLessons::class, 'private_lessons_id');
    }
}
