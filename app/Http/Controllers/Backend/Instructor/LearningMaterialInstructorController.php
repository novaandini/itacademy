<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\LearningMaterial; 
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class LearningMaterialInstructorController extends Controller 
{
    // Menampilkan semua learning materials yang dimiliki oleh instruktur yang sedang login
    public function index($module)
    {
        $instructorId = auth()->user()->id; // Mendapatkan nama instruktur yang sedang login

        // Mengambil learning materials yang terkait dengan kursus milik instruktur
        $data = [
            'module' => $module,
            'learningMaterials' => LearningMaterial::where('module_id', $module)->get(),
        ];

        return view('pages.backend.instructor.learning_materials.index', $data); // Mengembalikan view dengan data learning materials
    }

    // Menampilkan form untuk membuat learning material baru
    public function create($module)
    {
        // Mengambil kursus yang dibuat oleh instruktur yang sedang login
        $data = [
            'module' => $module,
            'data' => null,
        ];

        return view('pages.backend.instructor.learning_materials.form', $data); // Mengembalikan view dengan daftar kursus
    }

    // Menyimpan learning material baru ke database
    public function store(Request $request, $module)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'description' => 'required|string',
            ]);
            
            $file_name = null;
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $file_name = 'material_' .time() . '.' . $file->getClientOriginalExtension();
                $request->file('file_path')->storeAs('materials', $file_name, 'public');
            }

            $formdata = [
                'module_id' => $module, // Menyimpan ID kursus
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $file_name,
            ];

            // Menyimpan data ke database
            LearningMaterial::create($formdata);
            DB::commit();

            return redirect()->route('instructor.learning-materials.index', $module)->with('success', 'Learning Materials added successfully.'); // Mengalihkan dengan pesan sukses
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    // Menampilkan form untuk mengedit learning material
    public function edit($module, $id)
    {
        $data = [
            'module' => $module,
            // 'course' => Course::find($course),
            'data' => LearningMaterial::with('course')->findOrFail($id),
        ];
        return view('pages.backend.instructor.learning_materials.form', $data); // Mengembalikan view untuk mengedit
    }

    // Memperbarui learning material yang ada
    public function update(Request $request, $course, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi input
            $request->validate([
                'description' => 'required|string', // Memastikan deskripsi ada
            ]);
    
            // Menemukan learning material berdasarkan ID
            $learningMaterial = LearningMaterial::findOrFail($id);
            $file_name = $learningMaterial->file_path;
            
            if ($request->hasFile('file_path')) {
                if ($learningMaterial->file_path) {
                    Storage::delete($learningMaterial->file_path);
                }
                
                $file = $request->file('file_path');
                $file_name = 'material_' .time() . '.' . $file->getClientOriginalExtension();
                $request->file('file_path')->storeAs('materials', $file_name, 'public');
            }
    
            $formdata = [
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $file_name,
            ];
    
            $learningMaterial->update($formdata); // Menyimpan perubahan
            DB::commit();
    
            return redirect()->route('instructor.learning-materials.index', $course)->with('success', 'Learning materials have been successfully updated.'); // Mengalihkan setelah update
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    // Menghapus learning material
    public function destroy($course, $id)
    {
        DB::beginTransaction();
        try {
            $learningMaterial = LearningMaterial::findOrFail($id); // Mencari learning material berdasarkan ID
            if ($learningMaterial->file_path != null) {
                Storage::delete($learningMaterial->file_path); // Menghapus file dari storage
            }
            $learningMaterial->delete(); // Menghapus data dari database

            DB::commit();
            return redirect()->route('instructor.learning-materials.index', $course)->with('success', 'Learning materials have been successfully deleted.'); // Mengalihkan dengan pesan sukses
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
