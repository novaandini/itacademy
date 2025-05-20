<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_formats')->insert([
            [
                'id' => 1,
                'title' => 'Online Courses',
                'slug' => Str::slug('Online Courses'),
                'status' => 'show',
                'content' => '<ul class="p-0" style="list-style: none">
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Learn at your own pace with 24/7 access to materials.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Interactive lessons, live webinars, and practical assignments.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Options: Weekly, Monthly, Yearly, or Customized Programs.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Certificate provided after successful completion.</li>
                </ul>',
            ],
            [
                'id' => 2,
                'title' => 'Offline Courses',
                'slug' => Str::slug('Offline Courses'),
                'status' => 'show',
                'content' => '<ul class="p-0" style="list-style: none">
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Classroom-based learning with hands-on practice.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Direct interaction with expert instructors.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Options: Intensive (Weekly), Structured (Monthly), Comprehensive (Yearly), or Customized Programs.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Certificate provided after successful completion.</li>
                </ul>',
            ],
            [
                'id' => 3,
                'title' => 'Blended Courses',
                'slug' => Str::slug('Blended Courses'),
                'status' => 'show',
                'content' => '<ul class="p-0" style="list-style: none">
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Online theory combined with in-person practical workshops.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Ideal for flexible yet immersive learning.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Options: Intensive (Weekly), Structured (Monthly), Comprehensive (Yearly), or Customized Programs.</li>
                    <li><i class="fa fa-arrow-right text-primary me-2"></i>Certificate provided after successful completion.</li>
                </ul>',
            ],
        ]);
    }
}
