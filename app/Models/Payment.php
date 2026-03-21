<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'alumni_id',
        'registration_id',
        'event_registration_item_id',
        'amount',
        'mode',
        'reference_number',
        'or_number',
        'or_file_path',
        'paid_at',
        'status',
        'verified_by',
        'verified_at',
        'remarks',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }

    public function registrationItem()
    {
        return $this->belongsTo(EventRegistrationItem::class, 'event_registration_item_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    public function getPaymentForAttribute(): string
{
    return $this->registrationItem?->name ?? 'Event Registration Fee';
}
}