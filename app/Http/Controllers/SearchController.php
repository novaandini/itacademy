<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // Ganti dengan model yang sesuai

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Validasi input pencarian
        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }
        
        // Cari berdasarkan nama kursus
        $courses = Course::where('title', 'LIKE', '%' . $query . '%')->get();

        // Tampilkan hasil pencarian (sesuaikan dengan tampilan Anda)
        return view('courses.search', ['courses' => $courses, 'query' => $query]);
    }
}

