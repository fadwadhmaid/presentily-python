<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role',
        'section_id', 
        'school',
        'grade',
        'governorate',
        'age',
        'total_xp',
        'level',
        'current_chapter',
        'current_lesson',
        'completed_lessons',
        'completed_exercises',
        'streak_days',
        'last_activity_date',
        'avatar_config',
        'badges',
        'achievements',
        'subscription_type',
        'subscription_end_date',
        'is_premium',
        'email_verified_at',
        'email_verification_token',
        'reset_password_token',
        'reset_password_expires',
        'last_login',
        // 'failed_login_attempts', // COMMENTÉ
        // 'locked_until', // COMMENTÉ
        // 'ip_addresses', // COMMENTÉ
        // 'user_agent', // COMMENTÉ
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
        'reset_password_token',
        'reset_password_expires',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'reset_password_expires' => 'datetime',
        'last_login' => 'datetime',
        'last_activity_date' => 'date',
        'subscription_end_date' => 'date',
        'avatar_config' => 'array',
        'badges' => 'array',
        'achievements' => 'array',
        'is_premium' => 'boolean',
        'deleted_at' => 'datetime',
        // 'failed_login_attempts' => 'integer', // COMMENTÉ
        // 'locked_until' => 'datetime', // COMMENTÉ
        // 'ip_addresses' => 'array', // COMMENTÉ
    ];

    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
            
            // Initialiser les champs de sécurité - COMMENTÉ
            // $user->failed_login_attempts = 0;
            // $user->ip_addresses = [];
        });
    }
public function isAdmin(): bool
{
    return $this->role === 'admin';
}
    /**
     * Vérifier si l'utilisateur est verrouillé
     */
    public function isLocked(): bool
    {
        // return $this->locked_until && $this->locked_until->isFuture();
        return false; // TEMPORAIRE: désactivé
    }

    /**
     * Verrouiller l'utilisateur
     */
    public function lock(): void
    {
        // $this->locked_until = now()->addMinutes(30);
        // $this->save();
        // TEMPORAIRE: désactivé
    }

    /**
     * Incrémenter les tentatives de connexion échouées
     */
    public function incrementFailedLoginAttempts(): void
    {
        // $this->failed_login_attempts += 1;
        // if ($this->failed_login_attempts >= 5) {
        //     $this->lock();
        // }
        // $this->save();
        // TEMPORAIRE: désactivé
    }

    /**
     * Réinitialiser les tentatives de connexion
     */
    public function resetFailedLoginAttempts(): void
    {
        // $this->failed_login_attempts = 0;
        // $this->locked_until = null;
        // $this->save();
        // TEMPORAIRE: désactivé
    }

    /**
     * Ajouter une adresse IP
     */
    public function addIpAddress(string $ip): void
    {
        // $ips = $this->ip_addresses ?? [];
        // if (!in_array($ip, $ips)) {
        //     $ips[] = $ip;
        //     if (count($ips) > 10) {
        //         array_shift($ips);
        //     }
        //     $this->ip_addresses = $ips;
        //     $this->save();
        // }
        // TEMPORAIRE: désactivé
    }

    /**
     * Ajouter des points d'expérience
     */
    public function addXp(int $amount): void
    {
        $this->total_xp += $amount;
        $this->checkLevelUp();
        $this->save();
    }

    /**
     * Vérifier si l'utilisateur monte de niveau
     */
    protected function checkLevelUp(): void
    {
        $xpPerLevel = 500;
        $newLevel = floor($this->total_xp / $xpPerLevel) + 1;
        
        if ($newLevel > $this->level) {
            $this->level = $newLevel;
        }
    }

    /**
     * Vérifier si le compte est vérifié
     */
    public function isVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Scope pour les utilisateurs actifs
     */
    public function scopeActive($query)
    {
        return $query->where('last_activity_date', '>=', now()->subDays(7));
    }

        // ─── Relations ───────────────────────────────

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'user_courses')
            ->withPivot('progress', 'status', 'started_at', 'completed_at')
            ->withTimestamps();
    }
}