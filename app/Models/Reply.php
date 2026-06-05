<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    protected $table = 'replies';

    protected $fillable = [
        'help_request_id',
        'student_name',
        'reply_text',
    ];

    public function helpRequest(): BelongsTo
    {
        return $this->belongsTo(HelpRequest::class);
    }
}
