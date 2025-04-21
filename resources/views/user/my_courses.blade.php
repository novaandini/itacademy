@extends('layouts.main')

@section('konten')
    <div class="container mt-4">
        <h1 class="mb-4 text-center">My Courses</h1>

        @if ($transactionItems->isEmpty())
            <div class="alert alert-info text-center">You have no confirmed courses yet.</div>
        @else
            <div class="row">
                @foreach ($transactionItems as $transactionItem)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-lg course-card">
                            <a href="{{ route('courses.materials', $transactionItem->course->id) }}" class="text-decoration-none">
                                <img src="{{ asset('storage/courses/' . $transactionItem->course->image) }}"
                                    class="card-img-top img-fluid course-img" alt="{{ $transactionItem->course->title }}">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $transactionItem->course->title }}</h5>
                                    <p class="instructor-name">Instructor: {{ $transactionItem->course->instructor }}</p>
                                    <p class="card-text text-muted">
                                        {!! \Illuminate\Support\Str::limit($transactionItem->course->description, 100) !!}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .course-card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            background-color: #ffffff;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .course-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .course-card:hover .course-img {
            transform: scale(1.1);
        }

        .card-body {
            padding: 20px;
            text-align: left;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .instructor-name {
            font-size: 0.95rem;
            font-weight: 500;
            color: #333333;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        a.text-decoration-none {
            text-decoration: none;
        }

        a.text-decoration-none:hover .card-title {
            color: #007bff;
        }
    </style>
@endsection
