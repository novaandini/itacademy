<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Assignment; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller 
{
    // Menampilkan semua assignment yang terkait dengan pengguna
    public function index($course)
    {
        // Mengambil assignment beserta course dan submission untuk user yang sedang login
        $assignments = Assignment::with(['course', 'submissions' => function ($query) {
            $query->where('user_id', Auth::id()); // Memfilter submission berdasarkan user yang sedang login
        }])
            ->whereHas('course', function ($query) {
                $query->whereHas('transactionItems', function ($query) {
                    $query->whereHas('transaction', function ($query) {
                        $query->where('user_id', Auth::id()) // Memastikan user yang login memiliki transaksi
                            ->where('status', 'settlement'); // Memastikan status transaksi adalah settlement
                    });
                });
            })->get();

        $data = [
            'assignments' => $assignments,
            'course' => $course,
        ];

        return view('user.assignments.index', $data); // Mengembalikan view dengan data assignments
    }

    // Menampilkan form untuk mengirim submission untuk assignment tertentu
    public function create($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId); // Mencari assignment berdasarkan ID
        return view('user.assignments.submit', compact('assignment')); // Mengembalikan view untuk submit assignment
    }

    // Menyimpan submission untuk assignment
    public function store(Request $request, $assignmentId)
    {
        // Validasi input
        $request->validate([
            'answer_text' => 'nullable', // Teks jawaban opsional
            'answer_file' => 'nullable|file', // File jawaban opsional
        ]);

        $submission = new Submission(); // Membuat objek submission baru
        $submission->assignment_id = $assignmentId; // Menetapkan ID assignment
        $submission->user_id = Auth::id(); // Menetapkan ID user yang sedang login
        $submission->answer_text = $request->answer_text; // Menetapkan teks jawaban

        // Jika ada file yang diunggah, simpan file tersebut
        if ($request->hasFile('answer_file')) {
            $fileName = $request->file('answer_file')->store('public/submissions'); // Menyimpan file dan mendapatkan path
            $submission->answer_file = $fileName; // Menetapkan path file
        }

        $submission->save(); // Menyimpan submission ke database

        return redirect()->route('user.assignments.index')->with('success', 'Assignment berhasil disubmit!'); // Mengalihkan dengan pesan sukses
    }

    // Menampilkan semua submission yang telah disubmit untuk review
    public function review()
    {
        $submissions = Submission::with('assignment', 'user')->where('status', 'submitted')->get(); // Mengambil submission dengan status 'submitted'
        return view('admin.submissions.index', compact('submissions')); // Mengembalikan view dengan data submissions
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
