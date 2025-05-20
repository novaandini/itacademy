<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = Student::count() + 1;
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);

        $date = Carbon::now(); // Mendapatkan tanggal saat ini
        $formattedDate = $date->format('dmy');

        $student_number = $number . $formattedDate;

        DB::table('students')->insert([
            [
                'user_id' => 3,
                'student_id' => $student_number
            ],
        ]);
    }
}
