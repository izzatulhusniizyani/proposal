<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HelpRequest extends Model
{
    protected $fillable = [
        'user_id',
        'course_code',
        'topic',
        'description',
        'image_path',
        'status',
        'response_count',
    ];

    protected function casts(): array
    {
        return [
            'response_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Reply::class, 'help_request_id');
    }
}
