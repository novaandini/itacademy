<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseFormat;

class HomeController extends Controller
{
    public function index() {
        $courses = Course::with('user')->where('status', 'approved')->paginate(3)->through(function ($course) {
            $start_date = Carbon::parse($course->start_date);
            $end_date = Carbon::parse($course->end_date);

            $diff_months = $start_date->diffInMonths($end_date); // Hitung bulan penuh
            $remaining_days = $start_date->addMonths($diff_months)->diffInDays($end_date); // Hitung sisa hari setelah bulan dihitung
            $diff_weeks = intdiv($remaining_days, 7); // Hitung minggu penuh
            $diff_days = $remaining_days % 7; // Sisa hari setelah minggu dihitung

            if ($diff_months > 0) { 
                $course->duration = "$diff_months bulan";
            } elseif ($diff_weeks > 0) {
                $course->duration = "$diff_weeks minggu";
            } else {
                $course->duration = "$diff_days hari";
            }
            
            // $course->duration = $start_date->diffInDays($end_date) . ' hari';
            return $course;
        });

        $data = [
            'courses' => $courses,
            'formats' => CourseFormat::all(),
        ];

        return view('pages.frontend.home.index', $data);
    }
}
