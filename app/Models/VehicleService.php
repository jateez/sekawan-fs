<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleService extends Model
{
    protected $fillable = [
        'vehicle_id',
        'service_date',
        'next_service_date',
        'description'
    ];
}
