<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_services')->insert([
            'vehicle_id' => 1,
            'service_date' => now()->subMonths(3),
            'next_service_date' => now()->addMonths(3),
            'description' => 'Oil change and tire rotation',
        ]);
        DB::table('vehicle_services')->insert([
            'vehicle_id' => 2,
            'service_date' => now()->subMonths(2),
            'next_service_date' => now()->addMonths(4),
            'description' => 'Brake check and battery replacement',
        ]);
        DB::table('vehicle_services')->insert([
            'vehicle_id' => 3,
            'service_date' => now()->subMonths(1),
            'next_service_date' => now()->addMonths(2),
            'description' => 'Engine tuning',
        ]);
        // DB::table('vehicle_services')->insert([
        //     'vehicle_id' => 4,
        //     'service_date' => now()->subWeeks(6),
        //     'next_service_date' => now()->addMonths(5),
        //     'description' => 'Full inspection',
        // ]);
        // DB::table('vehicle_services')->insert([
        //     'vehicle_id' => 5,
        //     'service_date' => now()->subWeeks(4),
        //     'next_service_date' => now()->addMonths(6),
        //     'description' => 'Transmission check',
        // ]);
    }
}
