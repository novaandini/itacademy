<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardStudentController extends Controller
{
    public function index() {
        return view('pages.backend.student.dashboard.index');
    }
}
