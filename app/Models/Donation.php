<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'amount',
        'date_donated',
        'remarks',
        'reference_number',
        'or_file_path',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'paid_at',
        'paymongo_checkout_session_id',
        'is_paid',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'date_donated' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}