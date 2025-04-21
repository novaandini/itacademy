<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Models\LearningSchedule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LearningScheduleController extends Controller
{
    public function index(Request $request, $course)
    {
        // Initialize the query
        $query = LearningSchedule::with(['course', 'instructor']);

        // Check user role and apply course filter for students
        $user = Auth::user();
        if ($user->role === 'student') {
            // Ambil transaction berdasarkan user
            $transactionItems = TransactionItem::whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->pluck('course_id'); // Ambil course_id dari transaction items yang dimiliki siswa

            $query->whereIn('course_id', $transactionItems);
        }

        // Apply Course Filter from Request
        if ($request->has('course_filter') && $request->course_filter) {
            $query->where('course_id', $request->course_filter);
        }

        // Apply Instructor Filter from Request
        if ($request->has('instructor_filter') && $request->instructor_filter) {
            $query->where('instructor_id', $request->instructor_filter);
        }

        // Get the filtered schedules
        $schedules = $query->get();
        $courses = Course::all();
        $instructors = User::where('role', 'instructor')->get();

        return view('pages.backend.learning_schedule.index', compact('schedules', 'courses', 'instructors', 'course'));
    }


    public function store(Request $request)
    {
        Log::info('Request Data: ', $request->all());
        // Validate the incoming request data
        $request->validate([
            'date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'material' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'instructor_id' => 'required|exists:users,id', // Make sure this matches your instructor logic
        ]);

        // Create a new learning schedule
        LearningSchedule::create([
            'date' => $request->date,
            'course_id' => $request->course_id,
            'material' => $request->material,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'instructor_id' => $request->instructor_id,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Schedule added successfully.');
    }

    public function edit($id)
    {
        $schedule = LearningSchedule::with(['course', 'instructor'])->findOrFail($id);
        $courses = Course::all();
        $instructors = User::where('role', 'instructor')->get();

        return view('learning_schedule.edit', compact('schedule', 'courses', 'instructors'));
    }
    public function update(Request $request, $id)
    {
        // Log the incoming request data
        Log::info('Updating Schedule: ', $request->all());

        // Validate the incoming request data
        $request->validate([
            'date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'material' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'instructor_id' => 'required|exists:users,id', // Ensure this matches your instructor logic
        ]);

        // Find the existing learning schedule
        $schedule = LearningSchedule::findOrFail($id);

        // Update the learning schedule with new data
        $schedule->update([
            'date' => $request->date,
            'course_id' => $request->course_id,
            'material' => $request->material,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'instructor_id' => $request->instructor_id,
        ]);

        // Redirect back with a success message
        return redirect()->route('learning-schedule.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        // Find the schedule by ID
        $schedule = LearningSchedule::with(['course', 'instructor'])->findOrFail($id);

        // Delete the schedule
        $schedule->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }
}
