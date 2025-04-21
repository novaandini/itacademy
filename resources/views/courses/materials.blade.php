@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h1 class="mb-5 text-center">{{ $course->title }}</h1>

    @if($course->learningMaterials->isEmpty())
        <div class="alert alert-info text-center">No learning materials available for this course.</div>
    @else
        @php
            // Mengambil angka dari duration (misalnya: "30 hari")
            preg_match('/(\d+)/', $course->duration, $matches);
            $days = (int) $matches[0];

            // Hitung tanggal berakhirnya course berdasarkan tanggal transaksi
            $start_date = \Carbon\Carbon::parse($transaction->created_at);
            $end_date = $start_date->addDays($days);
            $now = \Carbon\Carbon::now();

            // Cek apakah durasi sudah habis
            $isExpired = $now->greaterThan($end_date);
        @endphp

        @if($isExpired)
            <div class="alert alert-danger text-center">This course is no longer accessible as the duration has expired.</div>
        @else
            <div class="row">
                <div class="col-12 mb-5 text-center">
                    <!-- Menambahkan gambar course dengan styling -->
                    <img src="{{ asset('assets/img/' . $course->image) }}" alt="{{ $course->title }}" class="course-image mb-4">
                    <h5 class="text-muted">Instructor: {{ $course->instructor }}</h5>
                    <p class="text-muted">Course Duration: {{ $course->duration }} day ({{ $end_date->diffForHumans() }} left)</p> <!-- Tampilkan durasi dan waktu tersisa -->
                </div>

                @foreach($course->learningMaterials as $material)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0 h-100 module-card">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title text-primary font-weight-bold">{{ $material->title }}</h5>
                                    <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($material->description, 100) }}</p>
                                </div>
                                <div>
                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn btn-custom btn-block mt-3">Download Module</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

<style>
    /* Styling untuk gambar course */
    .course-image {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-image:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
    }

    /* Styling untuk card module */
    .module-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        background-color: #fff;
        padding: 20px;
    }

    .module-card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Custom button */
    .btn-custom {
        background-color: #007bff;
        color: #fff;
        border-radius: 8px;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #0056b3;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .module-card {
            margin-bottom: 20px;
        }
    }
</style>
@endsection
