<?php

namespace App\Http\Controllers\Backend;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\News;

class AssignmentController extends Controller
{
    // Menampilkan daftar semua assignment yang dibuat oleh instructor yang sedang login
    public function index($course)
    {
        $instructorId = auth()->user()->id; // Mengambil nama instructorId yang sedang login

        // Mengambil assignment yang terkait dengan kursus yang diajarkan oleh instructorId ini
        $data = [
            'data' => Assignment::whereHas('course', function ($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })->orderBy('deadline', 'desc')->get(),
            'course' => $course
        ];

        // Mengembalikan view dengan data assignments
        return view('pages.backend.assignments.index', $data);
    }

    // Menampilkan form untuk membuat assignment baru
    public function create($course)
    {
        // Mengambil semua kursus yang diajarkan oleh instructor yang sedang login
        $data = [
            'course' => Course::find($course),
            'data' => null,
        ];
        return view('pages.backend.assignments.form', $data); // Mengembalikan view dengan data kursus
    }

    // Menyimpan assignment baru ke database
    public function store(Request $request, Assignment $assignment, $course)
    {
        DB::beginTransaction();
        try {
            $image = null;

            if ($request->file('file') != "") {
                $file = $request->file('file');
                $fileName = 'news_' .time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('file')->storeAs('news', $fileName, 'public');
                // $image = Storage::url($path); 
            }

            // Validasi input dari pengguna
            $request->validate([
                'description' => 'required', // Deskripsi assignment harus diisi
            ]);

            $formdata = [
                'title' => $request->title,
                'course_id' => $course,
                'description' => $request->description,
                'file_path' => $image,
                'deadline' => $request->deadline,
            ];

            $assignment->create($formdata);

            DB::commit();
            return redirect()->route('instructor.assignments.index', $course)->with('success', 'Assignment berhasil dibuat!');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    // Menampilkan form untuk mengedit assignment yang sudah ada
    public function edit($id)
    {
        
        $data = [
            'data' => Assignment::findOrFail($id), // Mencari assignment berdasarkan ID, jika tidak ditemukan, akan mengembalikan 404
            'courses' => Course::all() // Mengambil semua kursus untuk ditampilkan di form edit
        ];

        // Mengembalikan view dengan data assignment dan kursus
        return view('pages.backend.assignments.form', $data);
    }

    // Memperbarui assignment yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'course_id' => 'required', // ID kursus harus diisi
            'title' => 'required', // Judul assignment harus diisi
            'description' => 'required', // Deskripsi assignment harus diisi
            'file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // File bersifat opsional, tetapi jika ada, harus sesuai format
            'deadline' => 'required|date', // Deadline harus diisi dan merupakan tanggal yang valid
        ]);

        // Mencari assignment berdasarkan ID, jika tidak ditemukan, akan mengembalikan 404
        $assignment = Assignment::findOrFail($id);

        // Memperbarui file jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            // Mengunggah file dan menyimpannya di direktori 'assignments' dalam storage publik
            $filePath = $request->file('file')->store('assignments', 'public');
            $assignment->update(['file_path' => $filePath]); // Memperbarui path file assignment
        }

        // Memperbarui data assignment dengan data dari request
        $assignment->update($request->all());

        // Mengalihkan ke halaman index dengan pesan sukses
        return redirect()->route('instructor.assignments.index')->with('success', 'Assignment berhasil diupdate!');
    }

    // Menghapus assignment berdasarkan ID
    public function destroy($id)
    {
        // Mencari assignment berdasarkan ID, jika tidak ditemukan, akan mengembalikan 404
        $assignment = Assignment::findOrFail($id);
        $assignment->delete(); // Menghapus assignment dari database

        // Mengalihkan ke halaman index dengan pesan sukses
        return redirect()->route('instructor.assignments.index')->with('success', 'Assignment berhasil dihapus!');
    }
}
