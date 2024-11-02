<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleUsage extends Model
{
    protected $fillable = [
        'booking_id',
        'vehicle_id',
        'start_odometer',
        'end_odometer',
    ];
}
