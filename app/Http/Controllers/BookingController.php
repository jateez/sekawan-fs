<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\Driver;
use App\Models\Location;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user:id,name', 'vehicle:id,model', 'driver:id,name', 'location:id,name', 'approvals' => function ($query) {
            $query->orderBy('approval_level');
        }])->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings->map(function ($booking) {
                $firstApprover = $booking->approvals->where('approval_level', 'first')->first();
                $secondApprover = $booking->approvals->where('approval_level', 'second')->first();

                return [
                    'id' => $booking->id,
                    'user_name' => $booking->user->name,
                    'vehicle_model' => $booking->vehicle->model,
                    'driver_name' => $booking->driver->name,
                    'location_name' => $booking->location->name,
                    'start_date' => $booking->start_date,
                    'end_date' => $booking->end_date,
                    'status' => $booking->status,
                    'purpose' => $booking->purpose,
                    'is_fully_approved' => $firstApprover?->status === 'approved' && $secondApprover?->status === 'approved',
                    'approvers' => [
                        'first' => optional($firstApprover)->approver->name,
                        'second' => optional($secondApprover)->approver->name,
                    ],
                ];
            }),
            'user_role' => Auth::user()->role,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Bookings/CreateBooking', [
            'locations' => Location::all(['id', 'name']),
            'vehicles' => Vehicle::where('status', 'available')
                ->select(['id', 'model', 'plate_number', 'location_id'])
                ->get(),
            'drivers' => Driver::where('status', 'available')
                ->select(['id', 'name', 'location_id'])
                ->get(),
            'approvers' => User::where('role', 'approver')
                ->select(['id', 'name', 'approval_level'])
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have permission to perform this action.');
        }


        $validated = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'purpose' => 'required|string',
            'approver_1' => 'required|exists:users,id',
            'approver_2' => 'required|exists:users,id|different:approver_1',
        ]);

        $foundBooking = Booking::where('vehicle_id', $validated['vehicle_id'])
            ->where('status', '!=', 'completed', 'rejected')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->exists();

        if ($foundBooking) {
            return back()->with('error', 'The vehicle is already booked for the selected dates');
        };

        try {
            DB::transaction(function () use ($validated) {
                $booking = Booking::create([
                    'user_id' => Auth::id(),
                    'vehicle_id' => $validated['vehicle_id'],
                    'location_id' => $validated['location_id'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'status' => 'pending',
                    'driver_id' => $validated['driver_id'],
                    'purpose' => $validated['purpose'],
                ]);

                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $validated['approver_1'],
                    'approval_level' => 'first',
                    'status' => 'pending'
                ]);

                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $validated['approver_2'],
                    'approval_level' => 'second',
                    'status' => 'pending'
                ]);
            });

            return redirect()->route('bookings.index')
                ->with('success', 'Booking created successfully and sent for approval');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create booking. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return Inertia::render('Bookings/Details', [
            'booking' => Booking::with([
                'user:id,name',
                'vehicle:id,model',
                'driver:id,name',
                'location:id,name',
                'approvals' => function ($query) {
                    $query->orderBy('approval_level');
                },
            ])->find($booking->id),
            'current_user_id' => Auth::id(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function approve(Booking $booking)
    {

        $approval = $booking->approvals()
            ->where('approver_id', Auth::id())
            ->first();

        if (!$approval) {
            return back()->with('error', 'You are not authorized to approve this booking');
        }

        if ($approval->approval_level == 'second') {
            $firstApprovalStatus = $booking->approvals()
                ->where('approval_level', 'first')
                ->value('status');

            if ($firstApprovalStatus !== 'approved') {
                return back()->with('error', 'The first-level approval is required before you can approve this booking');
            }
        }

        if ($approval->status === 'approved') {
            return back()->with('error', 'You have already approved this booking');
        }

        DB::transaction(function () use ($approval, $booking) {
            $approval->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Check if both levels are approved to update the booking status
            $firstApprovalStatus = $booking->approvals()->where('approval_level', 'first')->value('status');
            $secondApprovalStatus = $booking->approvals()->where('approval_level', 'second')->value('status');

            if ($firstApprovalStatus === 'approved' && $secondApprovalStatus === 'approved') {
                $booking->update(['status' => 'approved']);
            }
        });

        return back()->with('success', 'Booking approved successfully');
    }
}
