<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Announcement extends Model
{
    protected $fillable = [
        'title',
        'body',
        'is_published',
        'published_at',
        'pinned',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'pinned' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
     public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
