<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem; 
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller 
{
    // Menampilkan kursus yang dimiliki oleh pengguna
    public function myCourses()
    {
        // Mengambil semua transaction items yang berhubungan dengan transaksi yang berstatus 'settlement'
        $transactionItems = TransactionItem::with('course') // Mengambil transaction items beserta relasi course
            ->whereHas('transaction', function ($query) {
                // Memfilter transaction untuk pengguna yang sedang login dengan status 'settlement'
                $query->where('user_id', Auth::id())
                      ->where('status', 'settlement');
            })
            ->get(); // Mendapatkan semua transaction items yang sesuai

        // Mengirim data transaction items ke view
        return view('user.my_courses', compact('transactionItems')); // Mengembalikan view dengan data
    }
}
