<?php

namespace App\Http\Controllers\Backend\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LearningSchedule;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Auth;

class ScheduleStudentController extends Controller
{
    public function index(Request $request, $course)
    {
        // Check user role and apply course filter for students
        $schedule = LearningSchedule::where('course_id', $course)->get();

        $data = [
            'datas' => $schedule,
            'course' => $course,
        ];

        return view('pages.backend.student.schedule.index', $data);
    }
}
