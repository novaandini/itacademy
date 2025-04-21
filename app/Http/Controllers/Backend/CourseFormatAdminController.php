<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use App\Models\CourseFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CourseFormatAdminController extends Controller
{
    public function index(CourseFormat $courseFormat) {
        $data = [
            'data' => $courseFormat->all(),
        ];
        return view('pages.backend.course_format.index', $data);
    }

    public function create() {
        $data = [
            'data' => null,
        ];
        return view('pages.backend.course_format.form', $data);
    }

    public function store(CourseFormat $courseFormat, Request $request) {
        DB::beginTransaction();
        try {
            $slug = Str::slug($request->title);
            $i = 1;

            while ($courseFormat::where('slug', '=', $slug)->exists()) {
                $slug = $slug . '-' . $i;
                $i++;
            };

            $formdata = [
                'title' => $request->title,
                'slug' => $slug,
                'status' => $request->status,
                'content' => $request->content,
            ];

            $courseFormat->create($formdata);
            DB::commit();
            return redirect()->route('admin.course-format.index')->with('success', 'Data successfully created');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(CourseFormat $courseFormat, $id) {
        $data = [
            'data' => $courseFormat->find($id),
        ];
        return view('pages.backend.course_format.form', $data);
    }

    public function update(CourseFormat $courseFormat, Request $request, $id) {
        DB::beginTransaction();
        try {
            $oldData = $courseFormat->find($id);

            if ($oldData->title == $request->title) {
                $slug = $oldData->slug;
            } else {
                $slug = Str::slug($request->title);
    
                // Periksa apakah slug sudah ada di database
                $originalSlug = $slug; // Simpan slug awal
                $count = 1;
    
                while ($courseFormat::where('slug', '=', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            $formdata = [
                'title'     => $request->title,
                'slug'      => $slug,
                'status'    => $request->status,
                'content'   => $request->content,
            ];

            $courseFormat::where('id', '=', $id)->update($formdata);

            DB::commit();
            return redirect()->route('admin.course-format.index')->with('success', 'Data successfully updated!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function destroy(CourseFormat $courseFormat, $id) {
        DB::beginTransaction();
        try {
            $courseFormat::where('id', '=', $id)->delete();
            DB::commit();
            return redirect()->route('admin.course-format.index')->with('success', 'Data successfully deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function upload(Request $request) {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $fileName = 'courseFormat_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('courseFormat', $fileName, 'public'); // Save to 'storage/app/public/uploads'
            $url = Storage::url($path); // Generate public URL for the image

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'Image upload failed.'], 400);
    }
}
