<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerSignup extends Model
{
    protected $fillable = [
        'user_id',
        'alumni_id',
        'committee_id',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}