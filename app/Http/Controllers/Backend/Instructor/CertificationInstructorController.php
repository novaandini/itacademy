<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationInstructorController extends Controller
{
    public function index($course) {
        $data = [
            'title' => 'Certification',
            'course' => $course,
            'data' => Certification::with('course')->where('course_id', $course)->get(),
        ];
        return view('pages.backend.instructor.certification.index', $data);
    }
}
