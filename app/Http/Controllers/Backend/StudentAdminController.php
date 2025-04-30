<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Mail\StudentValidation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class StudentAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.backend.admin.student.index');
    }

    public function pendingStudents() {
        $data = [
            'data' => User::where('role', 'student')
                    ->where('status', 'pending')
                    ->get(),
            'category' => 'pending',
        ];
        return view('pages.backend.admin.student.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function validation(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $status = $request->validation;
            $formdata = [
                'status' => $status,
            ];

            User::where('id', $id)->update($formdata);

            $user = User::find($id);
            $formdataEmail = [
                'name' => $user->name,
            ];

            if ($status == 'approved') {
                $student = [
                    'user_id' => $user->id,
                    'student_id' => $this->generateCertificateNumber(),
                ];
        
                Student::create($student);
            }
            
            Mail::to($user->email)->send(new StudentValidation($formdataEmail, $status));

            DB::commit();

            return redirect()->route('admin.student.pending')->with('success', 'Student '. $status .' successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    function generateCertificateNumber()
    {
        $count = Student::count() + 1;
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);

        $date = Carbon::now(); // Mendapatkan tanggal saat ini
        $formattedDate = $date->format('dmy');

        $student_number = $number . $formattedDate;

        return $student_number;
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
    public function show($id)
    {
        $data = [
            'data' => User::findOrFail($id),
        ];
        return view('pages.backend.admin.student.pending', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Student $student)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Student $student)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Student $student)
    // {
    //     //
    // }
}
