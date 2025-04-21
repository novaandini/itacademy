<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Course;
use App\Models\User;
use App\Services\PDFservice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{
    // Menampilkan halaman daftar sertifikasi dan kursus
    // In your Controller
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            // Ambil semua sertifikasi
            $certifications = Certification::all();
        } else {
            // Ambil sertifikasi untuk pengguna yang sedang masuk
            $certifications = Certification::where('user_id', $user->id)->get();
        }

        // Ambil semua kursus
        $courses = Course::all();

        // Kirim data ke view
        return view('certifications.index', compact('certifications', 'courses'));
    }



    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'certificate_number' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the certification
        Certification::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'certificate_number' => $request->certificate_number, // Add certificate number to the creation array
            'description' => $request->description,
            'date' => $request->date,
        ]);

        // Redirect back with a success message
        return redirect()->route('certifications.index')->with('success', 'Certification created successfully!');
    }


    // Display a specific certification for the user
    public function show($id)
    {
        $certification = Certification::findOrFail($id);

        // Memastikan hanya user yang memiliki sertifikasi atau admin yang bisa melihat detail
        if (Auth::user()->role != 'Admin' && Auth::user()->id != $certification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Mengembalikan view dengan data sertifikasi
        return view('certifications.show', compact('certification'));
    }

    public function edit($id)
    {
        $certification = Certification::findOrFail($id);

        // Check if the user is an admin
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('certifications.index')->with('error', 'Unauthorized action.');
        }

        // Get the list of courses and users to pass to the view
        $courses = Course::all();
        $users = User::all(); // Assuming you have a User model

        return view('certifications.edit', compact('certification', 'courses', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'certificate_number' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the user is an admin
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('certifications.index')->with('error', 'Unauthorized action.');
        }

        // Update the certification
        $certification = Certification::findOrFail($id);
        $certification->update([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'date' => $request->date,
            'certificate_number' => $request->certificate_number,
        ]);

        return redirect()->route('certifications.index')->with('success', 'Certification updated successfully!');
    }

    // Method untuk menghapus sertifikasi
    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);

        // Memastikan hanya admin yang bisa menghapus
        if (Auth::user()->role != 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $certification->delete();

        return redirect()->route('certifications.index')->with('success', 'Certification deleted successfully.');
    }

    protected $pdfService;

    public function __construct(PDFservice $pdfService)
    {
        $this->pdfService = $pdfService;
    }
    public function download($id)
    {
        // Ambil data sertifikasi dengan relasi user dan course
        $certification = Certification::with('user', 'course')->findOrFail($id);

        // Format tanggal jika ada
        $formattedDate = $certification->date
            ? Carbon::parse($certification->date)->format('F j, Y')
            : 'Date not provided';

        // Data yang akan diteruskan ke view
        $data = compact('certification', 'formattedDate');
        $fileName = 'certificate_' . str_replace(' ', '_', $certification->user->name) . '.pdf';

        // Gunakan PDFService untuk mengunduh PDF
        return $this->pdfService->generatePDF('certifications.download', $data, $fileName);
    }

    public function getUsersByCourse(Request $request)
    {
        $courseId = $request->input('course_id');

        // Ambil semua user yang telah melakukan transaksi untuk course yang dipilih
        $users = User::whereHas('transactions.transactionItems', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->get();

        return response()->json(['users' => $users]);
    }
}
