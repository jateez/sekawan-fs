<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $fillable = [
        'plate_number',
        'model',
        'type',
        'is_company_owned',
        'location_id',
        'status'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function gasConsumptions()
    {
        return $this->hasMany(GasConsumption::class);
    }

    public function services()
    {
        return $this->hasMany(VehicleService::class);
    }

    public function usages()
    {
        return $this->hasMany(VehicleUsage::class);
    }
}
