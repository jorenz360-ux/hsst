<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Alumni extends Model
{
    use HasFactory;

    protected function fname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    protected function lname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    protected function mname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }
protected $table = 'alumni';

protected $fillable = [
    'prefix',
    'lname',
    'fname',
    'mname',
    'suffix',

    'occupation',
    'cellphone',

    'address_line_1',
    'address_line_2',
    'city',
    'state_province',
    'postal_code',
    'country',
];
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

   public function user()
{
    return $this->hasOne(User::class, 'alumni_id');
}
public function events(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    return $this->belongsToMany(\App\Models\Event::class, 'event_registrations', 'alumni_id', 'event_id')
        ->withPivot(['fee_paid', 'paid_at', 'status'])
        ->withTimestamps();
}
public function involvement()
{
    return $this->hasOne(\App\Models\AlumniInvolvement::class);
}
public function rsvpEvents()
{
    return $this->belongsToMany(Event::class, 'event_rsvps')
        ->withPivot(['status', 'guest_count', 'remarks'])
        ->withTimestamps();
}
public function eventRsvps()
{
    return $this->hasMany(\App\Models\EventRsvp::class);
}

public function volunteerSignups()
{
    return $this->hasMany(\App\Models\VolunteerSignup::class);
}

public function latestVolunteerSignup()
{
    return $this->hasOne(\App\Models\VolunteerSignup::class)->latestOfMany();
}
public function educations()
{
    return $this->hasMany(AlumniEducation::class);
}
}

