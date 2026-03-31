<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Alumni extends Model
{
    use HasFactory;
protected $table = 'alumni';

    protected $fillable = [
        'lname',
        'fname',
        'mname',
        'batch_id',
        'is_batch_rep',

        'occupation',

        'address_line_1',
        'address_line_2',
        'city',
        'state_province',
        'postal_code',
        'country',
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

   public function user()
{
    return $this->hasOne(User::class, 'alumni_id');
}
public function events(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    return $this->belongsToMany(\App\Models\Event::class, 'event_registrations', 'alumni_id', 'event_id')
        ->withPivot(['fee_paid', 'paid_at', 'status'])
        ->withTimestamps();
}
public function involvement()
{
    return $this->hasOne(\App\Models\AlumniInvolvement::class);
}
}

