<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = Instructor::where('instructor_id', '!=', null)->count() + 1;
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);

        $date = Carbon::now(); // Mendapatkan tanggal saat ini
        $formattedDate = $date->format('dmy');

        $instructor_number = 'INS' . $number . $formattedDate;

        DB::table('instructors')->insert([
            [
                'user_id' => 2,
                'instructor_id' => $instructor_number
            ],
        ]);
    }
}
