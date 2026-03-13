<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'registration_id', 
        'amount',
        'mode',
        'remarks',
        'paymongo_checkout_session_id',
        'paid_at',
        'is_paid',
    ];
    protected $casts = [
        'paid_at' => 'datetime',
        'is_paid' => 'boolean',
    ];
    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
    public function registration()
{
    return $this->belongsTo(\App\Models\EventRegistration::class, 'registration_id');
}
}

