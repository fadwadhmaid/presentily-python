<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'section_id',
        'number',
        'title',
        'description',
        'category',
        'category_color',
        'duration',
        'lessons',
        'xp_reward',
        'is_active',
    ];

    protected $casts = [
        'number'    => 'integer',
        'duration'  => 'integer',
        'lessons'   => 'integer',
        'xp_reward' => 'integer',
        'is_active' => 'boolean',
    ];

    // ─── Relations ───────────────────────────────

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_courses')
            ->withPivot('progress', 'status', 'started_at', 'completed_at')
            ->withTimestamps();
    }

    // ─── Scopes ──────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForSection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('number');
    }
}