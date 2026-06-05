<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupChat extends Model
{
    protected $table = 'group_chats';

    protected $fillable = [
        'study_group_id',
        'student_name',
        'message_text',
    ];

    public function studyGroup(): BelongsTo
    {
        return $this->belongsTo(StudyGroup::class);
    }
}
