<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Booking 1
        $booking1 = DB::table('bookings')->insertGetId([
            'user_id' => 1,
            'vehicle_id' => 1,
            'location_id' => 1,
            'start_date' => '2023-10-20 08:00:00',
            'end_date' => '2023-10-21 17:00:00',
            'status' => 'pending',
            'driver_id' => 3,
            'purpose' => 'Business trip to client site',
            'created_at' => now()->subDays(11),
            'updated_at' => now()->subDays(9),
        ]);

        DB::table('booking_approvals')->insert([
            [
                'booking_id' => $booking1,
                'approver_id' => 2, // approver_1
                'approval_level' => 'first',
                'status' => 'pending'
            ],
            [
                'booking_id' => $booking1,
                'approver_id' => 3, // approver_2
                'approval_level' => 'second',
                'status' => 'pending'
            ]
        ]);

        // Booking 2
        $booking2 = DB::table('bookings')->insertGetId([
            'user_id' => 1,
            'vehicle_id' => 2,
            'location_id' => 1,
            'start_date' => '2023-10-25 09:00:00',
            'end_date' => '2023-10-26 18:00:00',
            'status' => 'pending',
            'driver_id' => 4,
            'purpose' => 'City inspection',
            'created_at' => now()->subDays(6),
            'updated_at' => now()->subDays(4),
        ]);

        DB::table('booking_approvals')->insert([
            [
                'booking_id' => $booking2,
                'approver_id' => 3, // approver_1
                'approval_level' => 'first',
                'status' => 'pending'
            ],
            [
                'booking_id' => $booking2,
                'approver_id' => 4, // approver_2
                'approval_level' => 'second',
                'status' => 'pending'
            ]
        ]);

        // Booking 3
        $booking3 = DB::table('bookings')->insertGetId([
            'user_id' => 1,
            'vehicle_id' => 3,
            'location_id' => 2,
            'start_date' => '2023-10-28 08:30:00',
            'end_date' => '2023-10-29 17:00:00',
            'status' => 'pending',
            'driver_id' => 5,
            'purpose' => 'Goods transportation',
            'created_at' => now()->subDays(4),
            'updated_at' => now()->subDays(2),
        ]);

        DB::table('booking_approvals')->insert([
            [
                'booking_id' => $booking3,
                'approver_id' => 4, // approver_1
                'approval_level' => 'first',
                'status' => 'pending'
            ],
            [
                'booking_id' => $booking3,
                'approver_id' => 5, // approver_2
                'approval_level' => 'second',
                'status' => 'pending'
            ]
        ]);
    }
}
