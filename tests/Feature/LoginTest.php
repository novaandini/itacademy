<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase; // Menggunakan database yang bersih untuk setiap tes

    /**
     * Test login dengan kredensial yang benar.
     */
    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student', // Atur peran jika ingin menguji peran tertentu
        ]);
    
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
    
        $response->assertRedirect('/courses'); // Sesuaikan dengan URL yang benar
        $this->assertAuthenticatedAs($user);
    }
    
    public function test_login_requires_email_and_password()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);
    
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }
    

    /**
     * Test login dengan kredensial yang salah.
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Membuat pengguna contoh
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Kirim permintaan POST ke route login dengan kredensial yang salah
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Pastikan login gagal dan pengguna diarahkan kembali ke halaman login
        $response->assertSessionHasErrors(); // Memastikan ada error pada session
        $this->assertGuest(); // Pastikan pengguna tidak terautentikasi
    }

    /**
     * Test validasi login dengan input yang kosong.
     */

    /**
     * Test logout pengguna.
     */
    public function test_user_can_logout()
    {
        // Membuat pengguna contoh dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Kirim permintaan POST ke route logout
        $response = $this->post('/logout');

        // Memastikan pengguna diarahkan setelah logout dan tidak lagi terautentikasi
        $response->assertRedirect('/'); // Asumsikan pengguna diarahkan ke halaman utama
        $this->assertGuest();
    }
}
