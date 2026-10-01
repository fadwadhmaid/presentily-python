<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'code',
        'name',
        'short_name',
        'description',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    // ─── Relations ───────────────────────────────

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class)->orderBy('number');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // ─── Scopes ──────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}