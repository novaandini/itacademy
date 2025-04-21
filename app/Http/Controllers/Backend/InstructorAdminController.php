<?php

namespace App\Http\Controllers\Backend;

use App\Mail\InstructorValidation;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class InstructorAdminController extends Controller
{
    public function index(Instructor $instructor) {
        $data =[
            'data' => User::where('status', 'approved')
                        ->where('role', 'instructor')
                        ->get(),
            'category' => 'approved'
        ];

        return view('pages.backend.admin.instructor.index', $data);
    }

    public function pendingInstructors()
    {
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('/')->with('error', 'You do not have permission to access this page.');
        }
        // Fetch all instructors with 'pending' status
        $data = [
            'data' => User::where('role', 'instructor')
                        ->where('status', 'pending')
                        ->get(),
            'category' => 'pending'
        ];
        return view('pages.backend.admin.instructor.index', $data);
    }

    public function show($id) {
        $data = [
            'data' => User::findOrFail($id),
        ];
        return view('pages.backend.admin.instructor.show', $data);
    }
    
    public function approveInstructor($id)
    {
        // Find the instructor and approve them
        $instructor = Instructor::findOrFail($id);

        // Generate a random password for the new user
        $password = Str::random(8);
    
        // Update instructor status to 'approved'
        $instructor->status = 'approved';
        $instructor->save();
    
        // Create a user account for the instructor with the generated password
        $user = User::firstOrCreate([
            'email' => $instructor->email
        ], [
            'name' => $instructor->name,
            'password' => Hash::make($password),
            'role' => 'instructor',
            'status' => $instructor->status,
            'address' => $instructor->address,
            'phone' => $instructor->phone,
            'date_of_birth' => $instructor->date_of_birth,
            'image' => $instructor->image,
        ]);
    
        // Redirect back with the generated email and password details
        return redirect()->route('admin.instructors.pending')
            ->with('success', "Instructor approved successfully. Email: {$instructor->email}, Password: {$password}");
    }
    
    public function rejectInstructor($id)
    {
        // Find the instructor in the Instructor table
        $instructor = Instructor::findOrFail($id);
    
        // Update the status of the instructor to 'rejected'
        $instructor->status = 'rejected';
        $instructor->save();
    
        // Find and delete the associated user record from the User table
        $user = User::where('email', $instructor->email)->first();
        
        if ($user) {
            $user->delete();  // Delete the user from the users table
        }
    
        // Redirect back with a success message indicating the instructor was rejected
        return redirect()->route('admin.instructors.pending')->with('success', 'Instructor rejected and user account deleted successfully.');
    }

    public function validation(Request $request, $id) {
        DB::beginTransaction();
        try {
            if ($request->validation == 'approve') {
                // Generate a random password for the new user
                $password = Str::random(8);
    
                $formdata = [
                    'password' => Hash::make($password),
                    'status' => 'approved'
                ];
    
                User::where('id', $id)->update($formdata);
    
                $user = User::find($id);
                $formdataEmail = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $password,
                ];
                
                Mail::to($user->email)->send(new InstructorValidation($formdataEmail, 'approved'));
                
                DB::commit();
                // Redirect back with the generated email and password details
                return redirect()->route('admin.instructor.pending')
                    ->with('success', "Instructor approved successfully. Email: {$user->email}, Password: {$password}");
            } else if ($request->validation == 'reject') {
                $formdata = [
                    'status' => 'rejected',
                ];
    
                User::where('id', $id)->update($formdata);

                $user = User::find($id);

                $formdataEmail = [
                    'name' => $user->name,
                ];
                
                Mail::to($user->email)->send(new InstructorValidation($formdataEmail, 'rejected'));
    
                DB::commit();
                return redirect()->route('admin.instructor.pending')
                    ->with('success', "Instructor rejected successfully.");
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

}
