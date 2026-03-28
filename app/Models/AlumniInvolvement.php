<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniInvolvement extends Model
{
    protected $fillable = [
        'alumni_id',
        'wants_committee_member',
        'is_priest_concelebrate',
        'is_medical_practitioner',
        'medical_specialty',
    ];

    protected $casts = [
        'wants_committee_member' => 'boolean',
        'is_priest_concelebrate' => 'boolean',
        'is_medical_practitioner' => 'boolean',
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }
}