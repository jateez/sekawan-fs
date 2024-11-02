<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('securepassword'),
            'role' => 'admin',
            'approval_level' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'Level 1 Approver',
            'email' => 'approver1@example.com',
            'password' => Hash::make('securepassword'),
            'role' => 'approver',
            'approval_level' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Level 2 Approver',
            'email' => 'approver2@example.com',
            'password' => Hash::make('securepassword'),
            'role' => 'approver',
            'approval_level' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Second Level 1 Approver',
            'email' => 'approver3@example.com',
            'password' => Hash::make('securepassword'),
            'role' => 'approver',
            'approval_level' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Second Level 2 Approver',
            'email' => 'approver4@example.com',
            'password' => Hash::make('securepassword'),
            'role' => 'approver',
            'approval_level' => 2,
        ]);
    }
}
