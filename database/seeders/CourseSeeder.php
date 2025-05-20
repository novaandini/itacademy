<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            'id' => '9edfeb8d-addb-4f90-89cc-6708fa472159',
            'user_id' => 2,
            'course_format_id' => 1,
            'course_category_id' => 1,
            'title' => 'Full Stack Web Development Bootcamp (Beginner to Advanced)',
            'price' => 100000,
            'discount' => 0,
            'discounted_price' => 100000,
            'start_date' => '2025-05-10',
            'end_date' => '2025-05-24',
            'capacity' => 10,
            'image' => 'course_1746845668.jpeg',
            'description' => 'Course Structure:
                Level: Beginner to Advanced

                Duration: 12 weeks (can be extended/flexible)

                Mode: Asynchronous video lectures + live weekly Q&A

                Tools: HTML, CSS, JavaScript, Git, Node.js, Express, MongoDB, React',
            'rating' => null,
            'reviews_count' => null,
            'status' => 'approved',
            'slug' => 'full-stack-web-development-bootcamp-beginner-to-advanced',
        ]);
    }
}
