<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasConsumption extends Model
{
    protected $fillable = [
        'date',
        'liters',
        'cost',
        'vehicle_id'
    ];
}
