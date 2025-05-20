<?php

namespace App\Http\Controllers\Backend\Instructor;

use Illuminate\Http\Request;
use App\Models\Certification;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CertificationInstructorController extends Controller
{
    public function index($course) {
        $student = StudentCourse::select(
            'student_courses.id',
            'student_courses.user_id',
            'student_courses.course_id',
            'student_courses.created_at',
            'student_courses.updated_at',
            DB::raw('ROUND((SELECT AVG(grade) FROM submissions WHERE submissions.user_id = student_courses.user_id), 1) as average_score')
        )->get();

        $data = [
            'title' => 'Certification',
            'course' => $course,
            'data' => $student,
        ];
            
        // dd($data);
        return view('pages.backend.instructor.certification.form', $data);
    }

    public function store($course, Request $request) {
        // dd($request->all());

        $scores = $request->score; // array [user_id => score]

        foreach ($scores as $userId => $score) {
            if (!is_null($score)) {
                Certification::create([
                    'course_id' => $course,
                    'user_id' => $userId,
                    'score' => $score,
                    'status' => 'pending',
                ]);
            }
        }

        return redirect()->route('instructor.certification.index', $course)->with('success', 'certification submited successfully');
    }
}
