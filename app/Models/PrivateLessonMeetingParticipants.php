<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivateLessonMeetingParticipants extends Model
{
    use HasFactory;


    protected $fillable = [
        'private_lesson_id',
        'meeting_id',
        'user_id',
        'lefting_at',
    ];


    /**
     * Get the meeting that owns the PrivateLessonMeetingParticipants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(PrivateLessonMeeting::class, 'meeting_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the private_lesson that owns the PrivateLessonMeetingParticipants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function private_lesson(): BelongsTo
    {
        return $this->belongsTo(PrivateLessons::class, 'private_lesson_id');
    }

}
