<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Mail\SubmissionReviewedByInstructor;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Assign;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubmissionInstructorController extends Controller
{
    public function index($course, $id)
    {
        $submission = Submission::with('user')->where('assignment_id', $id)->get();
        
        $data = [
            'course' => $course,
            'title' => Assignment::find($id)->title,
            'submission' => $submission,
        ];

        return view('pages.backend.instructor.submission.index', $data); // Mengembalikan view dengan data assignments
    }

    // Menampilkan form untuk mengirim submission untuk assignment tertentu
    public function create($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId); // Mencari assignment berdasarkan ID
        return view('pages.backend.instructor.submission.submit', compact('assignment')); // Mengembalikan view untuk submit assignment
    }

    // Menyimpan submission untuk assignment
    public function store(Request $request, $course, $id)
    {
        DB::beginTransaction();
        try {
            $formdata = [
                'grade' => $request->grade,
                'feedback' => $request->feedback,
                'status_review' => 'graded'
            ];
            
            $submission = Submission::find($id);
            $user = User::find($submission->user_id);

            $assignment = Assignment::find($submission->assignment_id);

            $form_email = [
                'name' => $user->name,
                'assignment_title' => $assignment->title,
            ];

            Submission::where('id', $id)->update($formdata);
            Mail::to($user->email)->send(new SubmissionReviewedByInstructor($form_email));
            DB::commit();

            return redirect()->route('instructor.submission.index', [$course, $id])->with('success', 'Feedback successfully submited');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    // Menampilkan semua submission yang telah disubmit untuk review
    public function review($course, $id)
    {
        $submission = Submission::with('user')->find($id);
        $data = [
            'data' => $submission,
            'course' => $course,
            'title' => Assignment::find($submission->assignment_id)->title,
        ];
        return view('pages.backend.instructor.submission.form', $data);
    }

    // Memberikan nilai untuk submission
    public function grade(Request $request, $id)
    {
        // Validasi input nilai
        $request->validate([
            'grade' => 'required|integer|min:0|max:100', // Memastikan nilai ada dan dalam rentang 0-100
        ]);

        $submission = Submission::findOrFail($id); // Mencari submission berdasarkan ID

        // Memperbarui submission dengan nilai yang diberikan oleh admin
        $submission->grade = $request->input('grade'); // Menetapkan nilai
        $submission->status = 'graded'; // Mengubah status menjadi 'graded'
        $submission->save(); // Menyimpan perubahan

        return redirect()->route('admin.submissions.index')->with('success', 'Nilai berhasil diberikan.'); // Mengalihkan dengan pesan sukses
    }
}
