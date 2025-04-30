<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function signup() {
        return view('pages.frontend.student.register');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|same:password',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
        
            // Check validation errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $imageName = 'default.jpg';
            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $imageName = time() . '.' . $image->getClientOriginalExtension();
            //     $image->move(public_path('../../public_html/assets/img/students'), $imageName);
            //     // $imageName = time() . '.' . $request->image->extension();  // Generate image file name
            //     // $request->image->move(public_path('assets/img/students'), $imageName);  // Save image in 'assets/img/instructors' folder
            // }
            
            if ($request->file('image') != "") {
                    $file = $request->file('image');
                    $imageName = 'instructor_' .time() . '.' . $file->getClientOriginalExtension();
                    $request->file('image')->storeAs('instructors', $imageName, 'public');
                }
    
            $formdata = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student', // Assign default role
                'image' => $imageName,
                'status' => 'pending',
            ];
        
            User::create($formdata);
        
            DB::commit();
            return redirect()->route('home')->with('success', 'Your registration is being processed. Please wait for your registration approval');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    // public function index(Request $request)
    // {
    //     // Ambil semua kursus untuk dropdown filter
    //     $courses = Course::all();

    //     if ($request->input('course')) {
    //         // Ambil data siswa berdasarkan course filter jika ada
    //         $selectedCourse = $request->input('course');

    //         $query = Transaction::whereHas('transactionItems', function ($query) use ($selectedCourse) {
    //             if ($selectedCourse) {
    //                 $query->whereHas('course', function ($query) use ($selectedCourse) {
    //                     $query->where('title', $selectedCourse);
    //                 });
    //             }
    //         })->with('user', 'transactionItems.course')->get();
            
    //         // Mengambil user unik dari transaksi yang ditemukan
    //         $students = $query->map(function ($transaction) {
    //             return $transaction->user;
    //         })->unique('id'); // Menghindari duplikat siswa
    //     } else {
    //         $selectedCourse = null;
    //         $students = User::where('role', 'student')->get();
    //     }


    //     return view('students.index', compact('students', 'courses', 'selectedCourse'));
    // }

    public function index(Request $request)
    {
        // Ambil semua kursus untuk dropdown filter
        // $courses = Course::all();

        // // Ambil data siswa berdasarkan course filter jika ada
        // $selectedCourse = $request->input('course');

        // $query = Transaction::whereHas('transactionItems', function ($query) use ($selectedCourse) {
        //     if ($selectedCourse) {
        //         $query->whereHas('course', function ($query) use ($selectedCourse) {
        //             $query->where('title', $selectedCourse);
        //         });
        //     }
        // })->with('user', 'transactionItems.course')->get();

        // Mengambil user unik dari transaksi yang ditemukan
        // $students = $query->map(function ($transaction) {
        //     return $transaction->user;
        // })->unique('id'); // Menghindari duplikat siswa
        $students = User::where('role', '=', 'student')->get();
        // dd($students);

        // return view('students.index2', compact('students', 'courses', 'selectedCourse'));
        return view('pages.frontend.student.index', compact('students'));
    }
    
    

    public function show($id)
    {
        // Fetch the user with 'student' role and their courses by ID
        $student = User::where('role', 'student')->with(relations: 'courses')->findOrFail($id);

        // Pass the student data to the 'students.show' view
        return view('pages.frontend.student.show', compact('student'));
    }
}
