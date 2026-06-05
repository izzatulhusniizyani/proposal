<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudySession extends Model
{
    protected $fillable = [
        'user_id',
        'course_code',
        'topic',
        'type',
        'location',
        'session_date',
        'session_time',
        'max_slots',
        'available_slots',
        'joined_count',
        'status',
        'material_path',
    ];

    protected function casts(): array
    {
        return [
            'max_slots' => 'integer',
            'available_slots' => 'integer',
            'joined_count' => 'integer',
            'session_date' => 'date:Y-m-d',
            'session_time' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'session_user')
            ->withTimestamps();
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(GroupChatMessage::class);
    }
}
