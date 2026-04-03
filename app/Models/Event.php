<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'venue',
        'event_date',
        'registration_fee',
        'description',
        'is_active',
        'dress_code',
        'banner_image',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $baseSlug = Str::slug($event->title);
            $slug = $baseSlug;
            $count = 1;

            while (self::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $event->slug = $slug;
        });

        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $baseSlug = Str::slug($event->title);
                $slug = $baseSlug;
                $count = 1;

                while (
                    self::where('slug', $slug)
                        ->where('id', '!=', $event->id)
                        ->exists()
                ) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $event->slug = $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function rsvps()
{
    return $this->hasMany(EventRsvp::class);
}
public function rsvpForAlumni($alumniId)
{
    return $this->rsvps()->where('alumni_id', $alumniId)->first();
}
}