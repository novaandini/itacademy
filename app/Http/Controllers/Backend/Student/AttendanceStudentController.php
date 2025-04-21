<?php

namespace App\Http\Controllers\Backend\Student;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AttendanceStudentController extends Controller
{
    public function index($course) {
        $hasCourses = true; // Default to true for non-students
        if (auth()->user()->role === 'student') {
            $hasCourses = StudentCourse::where('user_id', auth()->user()->id)->get();
        }
        
        $data = [
            'course' => $course,
            'hasCourses' => $hasCourses,
        ];

        return view('pages.backend.student.attendance.index', $data);
    }

    public function store(Request $request, $course) {
        DB::beginTransaction();
        try {
            $formdata = [
                'user_id' => auth()->id(),
                'date' => now(),
                'status' => $request->status,
                'reason' => $request->reason ?? null,
            ];
            
            Attendance::create($formdata);
            DB::commit();
    
            return redirect()->route('student.attendance.index', $course)->with('success', 'Attendance submitted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }
}
