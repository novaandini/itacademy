<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('student_courses')->insert([
            'user_id' => 3,
            'course_id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
        ]);
    }
}
