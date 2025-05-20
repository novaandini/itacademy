<?php

namespace App\Http\Controllers\Backend;

use App\Mail\CourseValidation;
use App\Models\Course;
use App\Models\CourseFormat;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CourseAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function pendingCourses() {
        $data = [
            'data' => Course::where('status', 'pending')->with('user')->get(),
            'title' => 'Pending Course List'
        ];
        return view('pages.backend.admin.course.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'data' => Course::findOrFail($id),
            'formats' => CourseFormat::all(),
            'programs' => CourseCategory::all(),
            'modules' => Module::where('course_id', $id)->get(),
        ];
        return view('pages.backend.admin.course.form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validation(Request $request, $id) {
        DB::beginTransaction();
        try {
            $course = Course::with('user')->findOrFail($id);

            $formdata = [
                'status' => $request->validation,
            ];
            $course->update($formdata);
            Mail::to($course->user->email)->send(new CourseValidation($course, $request->validation));

            DB::commit();

            return redirect()->route('admin.course.pending')->with('success', 'Course ' . $request->validation . ' successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
