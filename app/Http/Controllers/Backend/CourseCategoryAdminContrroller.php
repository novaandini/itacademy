<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CourseCategoryAdminContrroller extends Controller
{
    public function index(CourseCategory $courseCategory){
        $data = [
            'data' => $courseCategory::all(),
        ];
        return view('pages.backend.course_category.index', $data);
    }

    public function create() {
        $data = [
            'data' => null,
        ];
        return view('pages.backend.course_category.form', $data);
    }

    public function store(CourseCategory $courseCategory, Request $request) {
        DB::beginTransaction();
        try {
            $slug = Str::slug($request->title);
            $i = 1;

            while ($courseCategory::where('slug', '=', $slug)->exists()) {
                $slug = $slug . '-' . $i;
                $i++;
            };

            $formdata = [
                'title' => $request->title,
                'description' => $request->description,
                'slug' => $slug,
                'status' => $request->status,
            ];

            $courseCategory::create($formdata);
            DB::commit();
            return redirect()->route('admin.course-category.index')->with('success', 'Data successfully created!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
