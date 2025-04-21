<?php

namespace App\Http\Controllers\Backend\Student;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnSelf;

class AssignmentStudentController extends Controller
{
    public function index($course) {
        $data = [
            'course' => $course,
            'data' => Assignment::where('course_id', $course)->get(),
        ];

        return view('pages.backend.student.assignment.index', $data);
    }

    public function create($course, $id) {
        $data = [
            'course' => $course,
            'data' => Assignment::find($id),
        ];

        return view('pages.backend.student.assignment.form', $data);
    }

    public function store(Request $request, $course, $id) {
        DB::beginTransaction();
        try {
            $filename = null;

            if ($request->file('file') != "") {
                $file = $request->file('file');
                $fileName = 'news_' .time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('file')->storeAs('news', $fileName, 'public');
                $filename = Storage::url($path); 
            }

            $formdata = [
                'assignment_id' => $id,
                'user_id' => Auth::user()->id,
                'answer_text' => $request->content,
                'answer_file' => $filename,
                'status' => 'pending',
                'grade' => null,
            ];

            Submission::create($formdata);
            DB::commit();

            return redirect()->route('student.assignment.index', $course)->with('success', 'Assignment successfully submit');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }
}
