<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'alumni_id',
        'status',
        'guest_count',
        'remarks',
    ];

    protected $casts = [
        'guest_count' => 'integer',
    ];

    public const STATUS_ATTENDING = 'attending';
    public const STATUS_MAYBE = 'maybe';
    public const STATUS_NOT_ATTENDING = 'not_attending';

    public static function statuses(): array
    {
        return [
            self::STATUS_ATTENDING,
            self::STATUS_MAYBE,
            self::STATUS_NOT_ATTENDING,
        ];
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}