<?php

namespace App\Http\Controllers\Backend;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    // Menampilkan daftar semua assignment yang dibuat oleh instructor yang sedang login
    public function index($module)
    {
        $instructorId = auth()->user()->id; // Mengambil nama instructorId yang sedang login

        // Mengambil assignment yang terkait dengan kursus yang diajarkan oleh instructorId ini
        $data = [
            // 'data' => Assignment::whereHas('module', function ($query) use ($instructorId) {
            //     $query->where('user_id', $instructorId);
            // })->orderBy('deadline', 'desc')->get(),
            'data' => Assignment::where('module_id', $module)->get(),
            'module' => $module,
        ];

        // Mengembalikan view dengan data assignments
        return view('pages.backend.assignments.index', $data);
    }

    // Menampilkan form untuk membuat assignment baru
    public function create($module)
    {
        // Mengambil semua kursus yang diajarkan oleh instructor yang sedang login
        $data = [
            'data' => null,
            'module' => $module,
        ];
        return view('pages.backend.assignments.form', $data); // Mengembalikan view dengan data kursus
    }

    // Menyimpan assignment baru ke database
    public function store(Request $request, Assignment $assignment, $module)
    {
        DB::beginTransaction();
        try {
            $fileName = null;

            if ($request->file('file_path') != "") {
                $file = $request->file('file_path');
                $fileName = 'assignment_' .time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('file_path')->storeAs('assignments', $fileName, 'public');
                // $image = Storage::url($path); 
            }

            // Validasi input dari pengguna
            $request->validate([
                'description' => 'required', // Deskripsi assignment harus diisi
            ]);

            $formdata = [
                'title' => $request->title,
                'module_id' => $module,
                'description' => $request->description,
                'file_path' => $fileName,
                'deadline' => $request->deadline,
            ];

            $assignment->create($formdata);

            DB::commit();
            return redirect()->route('instructor.assignments.index', $module)->with('success', 'Assignment berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    // Menampilkan form untuk mengedit assignment yang sudah ada
    public function edit($module, $id)
    {
        $data = [
            'data' => Assignment::findOrFail($id),
            'module' => $module,
        ];

        // Mengembalikan view dengan data assignment dan kursus
        return view('pages.backend.assignments.form', $data);
    }

    // Memperbarui assignment yang sudah ada
    public function update(Request $request, $module, $id)
    {
        DB::beginTransaction();
        try {
            $assignment = Assignment::findOrFail($id);
            $fileName = $assignment->file_path;

            if ($request->file('file_path') != "") {
                $file = $request->file('file_path');
                $fileName = 'assignment_' .time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('file_path')->storeAs('assignments', $fileName, 'public');
                // $image = Storage::url($path); 
            }

            $formdata = [
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $fileName,
                'deadline' => $request->deadline,
            ];
    
            Assignment::where('id', $id)->update($formdata);
    
            DB::commit();
            return redirect()->route('instructor.assignments.index', $module)->with('success', 'Assignment berhasil diupdate!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }

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
