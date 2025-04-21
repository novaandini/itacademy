<?php

namespace App\Http\Controllers;

use Midtrans\Snap; 

class CheckoutController extends Controller 
{
    // Menampilkan halaman checkout
    public function index()
    {
        $cart = session('cart'); // Mengambil keranjang dari session
        $snapToken = $this->getSnapToken($cart); // Mengambil Snap token berdasarkan keranjang

        return view('checkout.index', compact('snapToken')); // Mengembalikan view checkout dengan Snap token
    }

    // Mengambil Snap token untuk pembayaran
    private function getSnapToken($cart)
    {
        // Menghitung total harga dengan memastikan bahwa price diubah menjadi integer
        $totalPrice = array_sum(array_map(function ($item) {
            return (int) $item['discountedPrice']; // Mengubah price menjadi integer
        }, $cart));

        // Mempersiapkan parameter untuk dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // ID unik untuk transaksi
                'gross_amount' => $totalPrice, // Total harga
            ],
            'item_details' => array_map(function ($item) {
                return [
                    'id' => $item['title'], // Menggunakan title sebagai ID item
                    'price' => (int) $item['discountedPrice'], // Ubah price menjadi integer
                    'quantity' => 1, // Quantity default 1
                    'name' => $item['title'], // Nama item diambil dari title
                ];
            }, $cart),
            'customer_details' => [
                'first_name' => auth()->user()->name, // Nama pelanggan
                'email' => auth()->user()->email, // Email pelanggan
            ],
        ];

        // Debugging untuk memastikan parameter sudah benar
        // (Kamu bisa menambahkan log atau dd($params) di sini jika perlu)

        // Meminta Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params); // Mendapatkan Snap token dari Midtrans
        return $snapToken; // Mengembalikan Snap token
    }

    // Menampilkan halaman sukses setelah pembayaran
    public function success()
    {
        session()->forget('cart'); // Mengosongkan keranjang setelah pembayaran sukses
        return view('user.my_courses'); // Mengembalikan view daftar kursus pengguna
    }
}
