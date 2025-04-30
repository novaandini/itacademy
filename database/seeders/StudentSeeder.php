<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now(); // Mendapatkan tanggal saat ini
        $formattedDate = $date->format('dmy');
        $student_id = '0001' . $formattedDate;

        DB::table('students')->insert([
            [
                'user_id' => 3,
                'student_id' => $student_id
            ],
        ]);
    }
}
