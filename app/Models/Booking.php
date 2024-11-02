<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'driver_id',
        'location_id',
        'start_date',
        'end_date',
        'status',
        'purpose',
        'approved_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approvals()
    {
        return $this->hasMany(BookingApproval::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function isFullyApproved()
    {
        $approvals = $this->approvals()->whereIn('approval_level', [1, 2])->get();
        return $approvals->count() === 2 && $approvals->every(function ($approval) {
            return $approval->status === 'approved';
        });
    }
}
