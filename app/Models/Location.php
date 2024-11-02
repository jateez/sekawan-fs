<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'type',
        'region'
    ];


    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

}
