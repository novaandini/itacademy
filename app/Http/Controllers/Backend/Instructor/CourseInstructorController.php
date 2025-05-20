<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\CourseFormat;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class CourseInstructorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $data = [
            'data' => Course::where('user_id', $user->id)->get(),
            'title' => 'Course List'
        ];
        return view('pages.backend.instructor.course.index', $data);
    }

    public function create() {
        $data = [
            'data' => null,
            'formats' => CourseFormat::all(),
            'programs' => CourseCategory::all(),
        ];
        return view('pages.backend.instructor.course.form', $data);
    }

    public function store(Request $request) {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $image = null;

            if ($request->file('image') != "") {
                $file = $request->file('image');
                $image = 'course_' .time() . '.' . $file->getClientOriginalExtension();
                $request->file('image')->storeAs('courses', $image, 'public');
            }
        
            // Get instructor name from the logged-in user
            $instructorId = Auth::user()->id;
        
            // Calculate discounted price if discount is provided
            $discount = $request->discount ?? 0; // Default to 0 if not provided
            $discountedPrice = $this->calculateDiscountedPrice($request->price, $discount);

            $slug = Str::slug($request->title);

            // Periksa apakah slug sudah ada di database
            $originalSlug = $slug; // Simpan slug awal
            $count = 1;

            while (Course::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $formdata = [
                'title' => $request->title,
                'price' => $request->price, // Save the original price
                'discount' => $discount, // Save the discount percentage
                'discounted_price' => $discountedPrice, // Save the final price after discount
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'user_id' => $instructorId,
                'course_format_id' => $request->formats_id,
                'course_categories_id' => $request->programs_id,
                'capacity' => $request->capacity,
                'image' => $image,
                'description' => $request->description,
                'slug' => $slug,
            ];
        
            // Create a new course
            $course = Course::create($formdata);

            $modules = [];
            foreach ($request->module_titles as $index => $title) {
                $modules[$index + 1] = [
                    'course_id' => $course->id,
                    'module_id' => Str::random(8),
                    'title' => $title,
                    'description' => $request->module_descriptions[$index] ?? '',
                    'learning_objectives' => $request->module_objectives[$index] ?? '',
                    'content' => $request->module_contents[$index] ?? '',
                    'duration_hours' => $request->module_durations[$index] ?? '',
                    'activities' => $request->module_activities[$index] ?? '',
                    'assessment_type' => $request->module_assesssment_types[$index] ?? '',
                    'passing_grade' => $request->module_passing_grades[$index] ?? 0,
                    'resources' => $request->module_resources[$index] ?? '',
                    'prerequisites' => $request->module_prerequisites[$index] ?? '',
                ];
            }
            // dd($modules);

            foreach ($modules as $module) {
                Module::create($module);
            };
        
            DB::commit();
            return redirect()->route('instructor.course.index')->with('success', 'Kursus berhasil didaftarkan. Mohon tunggu email dari kami terkait verifikasi kursus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Calculate discounted price based on original price and discount percentage.
     *
     * @param float $price
     * @param float $discount
     * @return float
     */
    private function calculateDiscountedPrice($price, $discount)
    {
        return $price - ($price * $discount / 100);
    }
}
