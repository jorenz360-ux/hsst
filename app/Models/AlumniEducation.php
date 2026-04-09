<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniEducation extends Model
{
    protected $table = 'alumni_educations';
    protected $fillable = [
        'alumni_id',
        'batch_id',
        'did_graduate',
        'school_year_attended',
        'is_batch_rep',
    ];

    protected $casts = [
        'did_graduate' => 'boolean',
        'is_batch_rep' => 'boolean',
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}