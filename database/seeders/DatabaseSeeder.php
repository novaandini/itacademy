<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            InstructorSeeder::class,
            CourseFormatSeeder::class,
            CourseProgramSeeder::class,
            CourseSeeder::class,
            ModuleSeeder::class,
            StudentCourseSeeder::class,
        ]);
        DB::table('category_news')->insert([
            [
                'id' => 1,
                'title' => 'IT',
                'slug' => Str::slug('IT'),
            ],
        ]);
        DB::table('news')->insert([
            [
                'title' => 'Bali IT Academy: Lembaga Kursus IT Terdepan di Bali',
                'slug' => Str::slug('Bali IT Academy: Lembaga Kursus IT Terdepan di Bali'),
                'category_id' => 1,
                'date' => '2024-12-29',
                'content' => '<p>Bali IT Academy hadir sebagai lembaga kursus IT unggulan yang berpusat di Bali, menawarkan solusi pendidikan teknologi yang inovatif untuk semua kalangan. Dengan berbagai jenis kursus yang tersedia, mulai dari pengembangan website, aplikasi mobile, hingga machine learning, Bali IT Academy menjadi pilihan tepat bagi siapa saja yang ingin menguasai keterampilan IT terkini.</p><h3><strong>Program Kursus Beragam</strong></h3><p>Bali IT Academy menyediakan berbagai program kursus yang dirancang untuk memenuhi kebutuhan industri masa kini. Beberapa program unggulannya meliputi:</p><ul><li><strong>Pengembangan Website:</strong> Belajar membuat website responsif dan modern menggunakan teknologi seperti HTML, CSS, JavaScript, dan framework populer seperti Laravel atau React.</li><li><strong>Aplikasi Mobile:</strong> Membuat aplikasi Android dan iOS dengan Flutter, React Native, atau teknologi native lainnya.</li><li><strong>Machine Learning:</strong> Mempelajari dasar hingga implementasi AI dan machine learning menggunakan Python, TensorFlow, atau PyTorch.</li></ul><h3><strong>Metode Pembelajaran Fleksibel</strong></h3><p>Untuk memastikan kenyamanan dan efektivitas pembelajaran, Bali IT Academy menawarkan tiga metode belajar:</p><ol><li><strong>Offline:</strong> Kelas tatap muka di pusat pelatihan dengan fasilitas lengkap di Bali.</li><li><strong>Online:</strong> Pembelajaran fleksibel dari mana saja dengan materi interaktif dan akses ke tutor profesional.</li><li><strong>Hybrid:</strong> Kombinasi belajar offline dan online untuk pengalaman belajar yang lebih dinamis.</li></ol><h3><strong>Mengapa Memilih Bali IT Academy?</strong></h3><ul><li><strong>Pengajar Profesional:</strong> Instruktur berpengalaman dengan latar belakang industri.</li><li><strong>Materi Terupdate:</strong> Silabus dirancang sesuai kebutuhan pasar kerja terkini.</li><li><strong>Jaringan Profesional:</strong> Kesempatan networking dengan komunitas IT di Bali.</li><li><strong>Sertifikat Kompetensi:</strong> Sertifikat resmi yang diakui untuk mendukung karir Anda.</li></ul><p>Bali IT Academy berkomitmen untuk membekali siswa dengan keterampilan yang relevan dan praktis di dunia IT. Dengan bergabung di Bali IT Academy, Anda tidak hanya belajar teknologi, tetapi juga membangun masa depan yang cerah di era digital.</p><p><strong>Informasi Pendaftaran</strong><br>Untuk informasi lebih lanjut mengenai program kursus dan pendaftaran, kunjungi situs web resmi Bali IT Academy atau hubungi layanan pelanggan melalui WhatsApp. Jangan lewatkan kesempatan untuk menjadi ahli IT bersama Bali IT Academy!</p>',
                'image' => '/storage/news/news_1735441696.png',
                'status' => 'show',
                'tags' => 'BelajarIT;BaliITAcademy;TeknologiUntukSemua',
                'keyword' => 'Bali IT Academy: Lembaga Kursus IT Terdepan di Bali',
                'caption' => 'Bali IT Academy',
            ],
        ]);
    }
}
