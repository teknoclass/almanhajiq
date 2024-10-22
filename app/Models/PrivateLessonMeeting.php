<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrivateLessonMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'private_lesson_id',
        'app_id',
        'token',
        'app_certificate',
        'channel',
        'url',
        'uid'
    ];


    /**
     * Get the private_lesson that owns the PrivateLessonMeetingParticipants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function private_lesson(): BelongsTo
    {
        return $this->belongsTo(PrivateLessons::class, 'private_lesson_id');
    }

    /**
     * Get all of the participants for the PrivateLessonMeeting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(PrivateLessonMeetingParticipants::class, 'meeting_id');
    }
}
