<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistrationItemSelection extends Model
{
    protected $fillable = [
        'registration_id',
        'event_registration_item_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }

    public function item()
    {
        return $this->belongsTo(EventRegistrationItem::class, 'event_registration_item_id');
    }
}