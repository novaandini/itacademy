<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed admin user ke database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'), // Pastikan ini adalah password yang aman
                'role' => 'admin', // Asumsikan ada field role
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Instructor',
                'email' => 'instructor@gmail.com',
                'password' => Hash::make('12345678'), // Pastikan ini adalah password yang aman
                'role' => 'instructor', // Asumsikan ada field role
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Student',
                'email' => 'student@gmail.com',
                'password' => Hash::make('12345678'), // Pastikan ini adalah password yang aman
                'role' => 'student', // Asumsikan ada field role
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
