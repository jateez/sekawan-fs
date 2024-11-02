<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicles')->insert([
            'plate_number' => 'B1234XYZ',
            'model' => 'Toyota Avanza',
            'location_id' => 1,
            'is_company_owned' => true,
            'status' => 'available',
            'type' => 'passenger',
        ]);

        DB::table('vehicles')->insert([
            'plate_number' => 'D5678ABC',
            'model' => 'Honda Jazz',
            'location_id' => 1,
            'is_company_owned' => false,
            'status' => 'available',
            'type' => 'passenger',
        ]);

        DB::table('vehicles')->insert([
            'plate_number' => 'E9101DEF',
            'model' => 'Isuzu Elf',
            'location_id' => 1,
            'is_company_owned' => true,
            'status' => 'maintenance',
            'type' => 'cargo',
        ]);

        DB::table('vehicles')->insert([
            'plate_number' => 'F2345GHI',
            'model' => 'Suzuki Ertiga',
            'location_id' => 2,
            'is_company_owned' => true,
            'status' => 'in-use',
            'type' => 'passenger',
        ]);

        DB::table('vehicles')->insert([
            'plate_number' => 'G6789JKL',
            'model' => 'Mitsubishi Fuso',
            'location_id' => 2,
            'is_company_owned' => false,
            'status' => 'available',
            'type' => 'cargo',
        ]);
    }
}
