<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use Illuminate\Http\Request;

class LearningMaterialStudentController extends Controller
{
    public function index($course) {
        $data = [
            'course' => $course,
            'data' => LearningMaterial::where('course_id', $course)->get()->sortBy('desc'),
        ];

        return view('pages.backend.student.material.index', $data);
    }
}
