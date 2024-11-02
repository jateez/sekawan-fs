<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_usages')->insert([
            'vehicle_id' => 1,
            'booking_id' => 1,
            'start_odometer' => 50000,
            'end_odometer' => 50500,
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        DB::table('vehicle_usages')->insert([
            'vehicle_id' => 2,
            'booking_id' => 2,
            'start_odometer' => 30000,
            'end_odometer' => 30350,
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        DB::table('vehicle_usages')->insert([
            'vehicle_id' => 3,
            'booking_id' => 3,
            'start_odometer' => 40000,
            'end_odometer' => 40600,
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ]);

        // DB::table('vehicle_usages')->insert([
        //     'vehicle_id' => 4,
        //     'booking_id' => 4,
        //     'start_odometer' => 15000,
        //     'end_odometer' => 15300,
        //     'created_at' => now()->subDays(2),
        //     'updated_at' => now()->subDays(2),
        // ]);

        // DB::table('vehicle_usages')->insert([
        //     'vehicle_id' => 5,
        //     'booking_id' => 5,
        //     'start_odometer' => 25000,
        //     'end_odometer' => 25600,
        //     'created_at' => now()->subDay(),
        //     'updated_at' => now()->subDay(),
        // ]);
    }
}
