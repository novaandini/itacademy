<?php

namespace App\Http\Controllers;

use App\Models\instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    // Menampilkan halaman profil pengguna
    public function edit()
    {
        $user = Auth::user();
        
        return view('profile.index', compact('user'));
    }

    // Mengupdate profil pengguna
    public function update(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mendapatkan ID pengguna yang sedang login
        $userId = Auth::id();

        // Mendapatkan nama gambar lama
        $oldImageName = DB::table('users')->where('id', $userId)->value('image');
        $oldImagePath = public_path('../../public_html/assets/img/users' . $oldImageName);

        // Mengunggah gambar jika ada
        if ($request->hasFile('image')) {
            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('../../public_html/assets/img/users'), $imageName);

            // Hapus gambar lama jika ada dan bukan gambar baru
            if ($oldImageName && file_exists($oldImagePath) && $oldImagePath !== public_path('../../public_html/assets/img/users' . $imageName)) {
                unlink($oldImagePath);
            }

            // Update nama gambar di database
            DB::table('users')->where('id', $userId)->update(['image' => $imageName]);
        }

        // Update informasi profil pengguna
        DB::table('users')->where('id', $userId)->update([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'date_of_birth' => $request->input('date_of_birth'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
    public function showProfile()
    {
        // Get the logged-in user
        $user = Auth::user();
        
        // Initialize $instructor as null by default
        $instructor = null;

        // Check if the user has an 'instructor' role
        if ($user->role === 'instructor') {
            // Fetch the approved instructor data based on the user's email
            $instructor = instructor::where('email', $user->email)
                                    ->where('status', 'approved')
                                    ->first();
        }

        // Pass both user and instructor data to the view
        return view('profile.index', compact('user', 'instructor'));
    }
}
