<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            'name' => 'Headquarters',
            'type' => 'headquarter',
            'address' => '123 Main St, Jakarta',
            'region' => 'Jakarta',
        ]);

        DB::table('locations')->insert([
            'name' => 'Branch Office',
            'type' => 'branch',
            'address' => '456 Elm St, Bandung',
            'region' => 'West Java',
        ]);

        DB::table('locations')->insert([
            'name' => 'Site 1',
            'type' => 'site',
            'address' => '789 Maple St, Surabaya',
            'region' => 'East Java',
        ]);

        DB::table('locations')->insert([
            'name' => 'Site 2',
            'type' => 'site',
            'address' => '101 Pine St, Yogyakarta',
            'region' => 'Yogyakarta',
        ]);

        DB::table('locations')->insert([
            'name' => 'Site 3',
            'type' => 'site',
            'address' => '202 Oak St, Semarang',
            'region' => 'Central Java',
        ]);

        DB::table('locations')->insert([
            'name' => 'Site 4',
            'type' => 'site',
            'address' => '303 Cedar St, Medan',
            'region' => 'North Sumatra',
        ]);

        DB::table('locations')->insert([
            'name' => 'Site 5',
            'type' => 'site',
            'address' => '404 Birch St, Makassar',
            'region' => 'South Sulawesi',
        ]);

        DB::table('locations')->insert([
            'name' => 'Site 6',
            'type' => 'site',
            'address' => '505 Cherry St, Bali',
            'region' => 'Bali',
        ]);
    }
}
