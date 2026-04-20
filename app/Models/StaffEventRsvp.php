<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffEventRsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'staff_id',
        'status',
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

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
