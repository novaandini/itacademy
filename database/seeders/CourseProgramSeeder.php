<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_categories')->insert([
            [
                'id' => 1,
                'title' => 'Web Development',
                'slug' => Str::slug('Web Development'),
                'description' => '',
                'status' => 'show'
            ]
        ]);
    }
}
