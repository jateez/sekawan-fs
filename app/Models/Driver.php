<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{

    protected $fillable = [
        'name',
        'status',
        'location_id',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
