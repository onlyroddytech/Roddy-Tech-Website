<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 *
 * The central authentication model for all platform users.
 * Role is controlled by the UserRole enum — access differs per role:
 *   Admin    → full admin panel, CMS, project/user management
 *   Client   → client dashboard, own projects only
 *   Supporter / Referral → limited dashboards (future phases)
 *
 * Key relationships:
 *   projects()            → projects assigned to this client (user_id FK)
 *   createdProjects()     → projects the admin created (created_by FK)
 *   messages()            → messages sent by this user in project threads
 *   appNotifications()    → in-app notifications from our own table
 *   unreadNotifications() → subset of above where is_read = false
 *   referrals()           → referral records where this user is the referrer
 *   referrer()            → the User who referred this user (nullable)
 *   blogPosts()           → posts authored by this user
 *
 * Note: appNotifications() is intentionally named to avoid collision with
 * the notifications() method provided by Laravel's Notifiable trait.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'phone',
        'referral_code', 'referred_by', 'is_active', 'last_seen_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_seen_at'      => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'role'              => UserRole::class,
        ];
    }

    // ── Relationships ──────────────────────────────────────────

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id')->latest();
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id')->where('is_read', false);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'user_id');
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    // ── Helpers ────────────────────────────────────────────────

    public function isAdmin(): bool  { return $this->role === UserRole::Admin; }
    public function isClient(): bool { return $this->role === UserRole::Client; }

    public function unreadNotificationCount(): int
    {
        return $this->unreadNotifications()->count();
    }

    public function referralLink(): string
    {
        return route('register') . '?ref=' . $this->referral_code;
    }
}
