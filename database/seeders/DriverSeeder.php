<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('drivers')->insert([
            'name' => 'John Smith',
            'status' => 'available',
            'location_id' => 1,
        ]);

        DB::table('drivers')->insert([
            'name' => 'Alice Johnson',
            'status' => 'assigned',
            'location_id' => 1,
        ]);

        DB::table('drivers')->insert([
            'name' => 'Michael Brown',
            'status' => 'available',
            'location_id' => 1,
        ]);

        DB::table('drivers')->insert([
            'name' => 'Emily Davis',
            'status' => 'available',
            'location_id' => 2,
        ]);

        DB::table('drivers')->insert([
            'name' => 'Chris Wilson',
            'status' => 'available',
            'location_id' => 2,
        ]);
    }
}
