<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'venue',
        'event_date',
        'registration_fee',
        'description',
        'is_active',
        'dress_code',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function alumni(): BelongsToMany
    {
        return $this->belongsToMany(Alumni::class, 'event_registrations', 'event_id', 'alumni_id')
            ->withPivot(['fee_paid', 'paid_at', 'status'])
            ->withTimestamps();
    }

    // public function schedules()
    // {
    //     return $this->hasMany(EventSchedule::class)
    //         ->orderBy('sort_order')
    //         ->orderBy('schedule_time');
    // }
    // public function registrationItems()
    // {
    //     return $this->hasMany(EventRegistrationItem::class)->orderBy('sort_order');
    // }
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
    public function registrationItems()
{
    return $this->hasMany(EventRegistrationItem::class)
        ->where('is_active', true)
        ->orderBy('sort_order');
}

public function schedules()
{
    return $this->hasMany(EventSchedule::class)
        ->orderBy('sort_order')
        ->orderBy('schedule_time');
}
}