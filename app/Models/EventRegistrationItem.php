<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistrationItem extends Model
{
    protected $fillable = [
        'event_id',
        'event_schedule_id',
        'name',
        'description',
        'price',
        'is_required',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function selections()
    {
        return $this->hasMany(EventRegistrationItemSelection::class);
    }
    public function payments()
{
    return $this->hasMany(Payment::class, 'event_registration_item_id');
}
public function schedule()
{
    return $this->belongsTo(EventSchedule::class, 'event_schedule_id');
}
}