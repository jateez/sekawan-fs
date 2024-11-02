<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingApproval extends Model
{
    protected $fillable = [
        'booking_id',
        'approver_id',
        'approval_level',
        'status',
        'approved_at',
        'notes'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
