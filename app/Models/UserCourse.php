<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCourse extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'progress',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'progress'     => 'integer',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ─── Relations ───────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}