<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleInstructorController extends Controller
{
    public function index($course) {
        $data = [
            'data' => Module::where('course_id', $course)->get(),
            'course' => $course,
        ];

        return view('pages.backend.instructor.module.index', $data);
    }

    public function edit($course, $id) {
        $data = [
            'data' => Module::where('module_id', $id)->first(),
            'course' => $course,
            'id' => $id,
        ];

        return view('pages.backend.instructor.module.form', $data);
    }

    public function update($course, $id, Request $request) {
        DB::beginTransaction();
        try {
            $formdata = [
                'title' => $request->title,
                'description' => $request->description ?? '',
                'learning_objectives' => $request->learning_objectives ?? '',
                'content' => $request->content ?? '',
                'duration_hours' => $request->duration_hours ?? 0,
                'activities' => $request->activities ?? '',
                'assessment_type' => $request->assessment_type ?? '',
                'passing_grade' => $request->passing_grade ?? 0,
                'resources' => $request->resources ?? '',
                'prerequisites' => $request->prerequisites ?? '',
                'module_status' => $request->status,
            ];

            Module::where('module_id', $id)->update($formdata);

            DB::commit();
            return redirect()->route('instructor.module.index', $course)->with('success', 'Module successfully updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }
}
