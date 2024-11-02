<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GasConsumptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 1,
            'date' => now()->subDays(10),
            'liters' => 40.5,
            'cost' => 500000,
        ]);

        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 2,
            'date' => now()->subDays(10),
            'liters' => 30,
            'cost' => 500000,
        ]);
        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 1,
            'date' => now()->subDays(10),
            'liters' => 20.5,
            'cost' => 250000,
        ]);
        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 2,
            'date' => now()->subDays(5),
            'liters' => 30.0,
            'cost' => 300000,
        ]);
        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 3,
            'date' => now()->subDays(3),
            'liters' => 60.0,
            'cost' => 750000,
        ]);
        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 4,
            'date' => now()->subDays(2),
            'liters' => 35.5,
            'cost' => 420000,
        ]);
        DB::table('gas_consumptions')->insert([
            'vehicle_id' => 5,
            'date' => now()->subDay(),
            'liters' => 50.0,
            'cost' => 620000,
        ]);
    }
}
