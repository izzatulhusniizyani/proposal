<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyGroup extends Model
{
    protected $table = 'study_groups';

    protected $fillable = [
        'user_id',
        'course_code',
        'topic',
        'location',
        'date',
        'time',
        'participant_limit',
        'joined_count',
        'status',
        'material_path',
    ];

    protected function casts(): array
    {
        return [
            'participant_limit' => 'integer',
            'joined_count' => 'integer',
            'date' => 'date:Y-m-d',
            'time' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')
            ->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'study_group_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'study_group_id');
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(GroupChat::class, 'study_group_id');
    }

    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->participant_limit - $this->joined_count);
    }
}
