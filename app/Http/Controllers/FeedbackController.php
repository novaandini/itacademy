<?php

namespace App\Http\Controllers; 

use App\Models\Feedback;
use App\Models\User; 
use Illuminate\Http\Request; 

class FeedbackController extends Controller 
{
    // Menampilkan form untuk membuat feedback baru
    public function create()
    {
        $users = User::where('role', 'student')->get(); // Mengambil daftar pengguna dengan peran 'student'
        return view('admin.feedback.create', compact('users')); // Mengembalikan view untuk membuat feedback
    }

    // Menyimpan feedback yang diberikan oleh admin
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id', // Memastikan user_id ada dan valid
            'comments' => 'required|string', // Memastikan komentar ada dan berupa string
            'rating' => 'nullable|integer|min:1|max:5', // Rating opsional, jika ada harus integer antara 1 hingga 5
        ]);

        // Membuat feedback baru
        Feedback::create([
            'user_id' => $request->user_id, // Mengambil user_id dari input
            'admin_id' => auth()->id(), // Mengambil admin_id dari pengguna yang sedang login
            'comments' => $request->comments, // Mengambil komentar dari input
            'rating' => $request->rating, // Mengambil rating dari input
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil diberikan.'); // Mengalihkan ke halaman index feedback dengan pesan sukses
    }

    // Menampilkan semua feedback yang telah diberikan
    public function index()
    {
        $feedbacks = Feedback::with('user', 'admin')->get(); // Mengambil semua feedback dengan relasi user dan admin
        return view('admin.feedback.index', compact('feedbacks')); // Mengembalikan view daftar feedback
    }

    // Menampilkan feedback untuk pengguna tertentu
    public function showForUser($userId)
    {
        $feedbacks = Feedback::where('user_id', $userId)->with('admin')->get(); // Mengambil feedback berdasarkan user_id
        return view('user.feedback.index', compact('feedbacks')); // Mengembalikan view feedback untuk pengguna
    }

    // Menampilkan form untuk mengedit feedback
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id); // Mencari feedback berdasarkan ID
        $users = User::where('role', 'student')->get(); // Mengambil daftar pengguna dengan peran 'student' (jika ingin mengubah info pengguna)
        return view('admin.feedback.edit', compact('feedback', 'users')); // Mengembalikan view untuk memperbarui feedback
    }

    // Memperbarui feedback yang ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'comments' => 'required|string', // Memastikan komentar ada dan berupa string
            'rating' => 'nullable|integer|min:1|max:5', // Rating opsional, jika ada harus integer antara 1 hingga 5
        ]);

        $feedback = Feedback::findOrFail($id); // Mencari feedback berdasarkan ID
        $feedback->update([ // Memperbarui feedback
            'comments' => $request->comments, // Mengupdate komentar
            'rating' => $request->rating, // Mengupdate rating
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully.'); // Mengalihkan ke halaman index feedback dengan pesan sukses
    }

    // Menghapus feedback
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); // Mencari feedback berdasarkan ID
        $feedback->delete(); // Menghapus feedback dari database

        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully.'); // Mengalihkan ke halaman index feedback dengan pesan sukses
    }
}
