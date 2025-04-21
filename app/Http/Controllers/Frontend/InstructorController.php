<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Mail\TestEmail;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class InstructorController extends Controller
{
    public function register() {
        return view('pages.frontend.instructor.register');
    }

    public function index()
    {
        // Fetch instructors from the 'instructors' table with status 'approve'
        $instructors = User::where('role', 'instructor')->where('status', 'approved')->get();
    
        // Pass instructors to the view
        return view('pages.frontend.instructor.index', compact('instructors'));
    }
    

    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('pages.frontend.instructor.show', compact('instructor'));
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email',
                'skills' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'description' => 'required|string|max:1000',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $imageName = 'default.jpg';
            // Handle the profile image upload
            // if ($request->hasFile('image')) {
            //     $imageName = time() . '.' . $request->image->extension();  // Generate image file name
            //     $request->image->move(public_path('../../public_html/assets/img/instructors'), $imageName);  // Save image in 'assets/img/instructors' folder
            // }
            
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $imageName = 'instructor_' .time() . '.' . $file->getClientOriginalExtension();
                $request->file('image')->storeAs('instructors', $imageName, 'public');
            }
        
            // Handle the CV upload
            // if ($request->hasFile('cv')) {
            //     $cvName = time() . '.' . $request->cv->extension();  // Generate CV file name
            //     $request->cv->move(public_path('../../public_html/assets/cvs/instructors'), $cvName);  // Save CV in 'assets/cvs/instructors' folder
            // }
            if ($request->file('cv') != "") {
                $file = $request->file('cv');
                $cvName = 'cv_' .time() . '.' . $file->getClientOriginalExtension();
                $request->file('cv')->storeAs('cvs', $cvName, 'public');
            }
    
            // Store the new instructor data
            $formdata = [
                'name' => $request->name,
                'email' => $request->email,
                'image' => $imageName,
                'address' => $request->address,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'description' => $request->description,
                'status' => 'pending',
                'role' => 'instructor',
            ];
    
            $user = User::create($formdata);

            $formdataInstructor = [
                'user_id' => $user->id,
                'skills' => $request->skills,
                'cv' => $cvName,
            ];
    
            Instructor::create($formdataInstructor);
            DB::commit();
        
            // Redirect back with a success message
            return redirect()->route('home')->with('success', 'Your registration is being processed. We will contact you via WhatsApp');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

}
