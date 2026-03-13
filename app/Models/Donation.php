<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'amount',
        'date_donated',
        'remarks',
        'paymongo_checkout_session_id',
        'paid_at',
    ];
    protected $casts = [
    'paid_at' => 'datetime',
    'date_donated' => 'datetime',
];
    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
    
}

