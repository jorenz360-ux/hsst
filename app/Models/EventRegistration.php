<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'event_registrations';

    protected $fillable = [
        'event_id',
        'alumni_id',
        'status',
        'fee_paid',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    public function alumni()
    {
        return $this->belongsTo(\App\Models\Alumni::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'registration_id');
    }
}