<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'alumni_id',
        'staff_id',
        'must_change_password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function alumni()
    {
        return $this->belongsTo(\App\Models\Alumni::class, 'alumni_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Staff::class, 'staff_id');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(\App\Models\Announcement::class, 'created_by');
    }

    public function eventsCreated(): HasMany
    {
        return $this->hasMany(\App\Models\Event::class, 'created_by');
    }

    public function volunteerSignups()
    {
        return $this->hasMany(\App\Models\VolunteerSignup::class);
    }

    public function latestVolunteerSignup()
    {
        return $this->hasOne(\App\Models\VolunteerSignup::class)->latestOfMany();
    }

    public function passwordResetRequests(): HasMany
    {
        return $this->hasMany(\App\Models\PasswordResetRequest::class);
    }
}
