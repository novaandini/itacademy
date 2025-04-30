<?php

namespace App\Http\Controllers\Backend;

use App\Models\Course;
use App\Models\CourseFormat;
use Illuminate\Http\Request;
use App\Models\Certification;
use App\Models\StudentCourse;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use PhpParser\Node\Expr\Assign;

class CertificationAdminController extends Controller
{
    public function index() {
        $uniqueCoursesWithCount = Certification::with('course')->where('status', 'pending')->select('course_id', DB::raw('COUNT(*) as students_count'))
        ->groupBy('course_id')
        ->get();

        $data = [
            'title' => 'Pending Certification',
            'data' => $uniqueCoursesWithCount,
        ];

        return view('pages.backend.admin.certification.index', $data);
    }

    public function show($id) {
        $certificates = Certification::with('user')
                        ->where('course_id', $id)
                        ->where('status', 'pending')
                        ->get();

        $course = Course::find($id);
        $assignment = Assignment::where('course_id', $id)->get();

        $scores = DB::table('submissions')
            ->join('assignments', 'submissions.assignment_id', '=', 'assignments.id')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->where('assignments.course_id', $id)
            ->select('assignments.title as assignment_title', 'users.id as user_id', 'users.name as student_name', 'submissions.grade')
            ->get();

        // Organize the scores into an associative array
        $scoreMatrix = [];

        foreach ($scores as $score) {
            $scoreMatrix[$score->student_name][$score->assignment_title] = $score->grade;
        }
        
        foreach ($certificates as $certificate) {
            $scoreMatrix[$certificate->user->name]['final_score'] = $certificate->score;
        }        

        $data = [
            'title' => $course->title,
            'course' => $course,
            'students' => StudentCourse::where('course_id', $id)->get(),
            'student_score' => $certificates,
            'formats' => CourseFormat::all(),
            'programs' => CourseCategory::all(),
            'scoreMatrix' => $scoreMatrix,
            'assignments' => $assignment
        ];

        return view('pages.backend.admin.certification.form', $data);
    }

    function generateCertificateNumber()
    {
        $count = \App\Models\Certification::count() + 1; // ambil jumlah sertifikat yg sudah ada
        $number = str_pad($count, 3, '0', STR_PAD_LEFT); // format 3 digit, misal 001, 002

        $institution = 'LEMBAGA'; // bisa diganti sesuai nama lembaga
        $monthRoman = $this->getMonthInRoman(date('m')); // konversi bulan ke romawi
        $year = date('Y');

        return "{$number}/{$institution}/{$monthRoman}/{$year}";
    }

    // helper untuk bulan romawi
    function getMonthInRoman($month)
    {
        $romans = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII',
        ];

        return $romans[$month];
    }

}
