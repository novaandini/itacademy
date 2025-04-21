<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\CourseFormat;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            Course::create($formdata);
        
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
