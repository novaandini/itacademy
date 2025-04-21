<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentInstructorController extends Controller
{
    public function index($id = null) {
        if ($id != null) {
            $data = [
                'data' => StudentCourse::where('course_id', $id)->with('user')->get(),
            ];
        } else {
            $user = Auth::user();
            $data = [
                'data' => Course::where('user_id', $user->id)->with('students')->get(),
            ];

        }
    
        return view('pages.backend.instructor.students.index', $data);

    }

    public function show($id) {
    }
}
