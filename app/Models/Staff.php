<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'address_line_1',
        'address_line_2',
        'city',
        'state_province',
        'postal_code',
        'country',
        'years_working',
        'position',
    ];

    protected function fname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    protected function lname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    protected function mname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'staff_id');
    }
}
