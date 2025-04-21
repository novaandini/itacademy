@extends('layouts.main')

@section('konten')

<!-- Alert for Registration -->
@if(session('status'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
            <h1 class="mb-3">Expert Instructors</h1>
            <!-- Join Instructor Button -->
            <a href="{{ route('instructor.register') }}" class="btn btn-outline-primary mb-5">
                <i class="fas fa-user-plus"></i> Join as Instructor
            </a>
        </div>
        <div class="row g-4">
            @foreach($instructors as $instructor)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative overflow-hidden shadow-lg rounded-4">
                        <div class="image-wrapper position-relative text-center">
                            @if($instructor->image)
                            <a href="{{ route('instructor.show', $instructor->id) }}">
                                <img class="img-fluid instructor-img rounded-top" 
                                     src="{{ asset('storage/' .$instructor->image) }}" 
                                     alt="{{ $instructor->name }}">
                            </a>
                        @else
                            <a href="{{ route('instructor.show', $instructor->id) }}">
                                <div class="placeholder-circle">
                                    {{ strtoupper(substr($instructor->name, 0, 1)) }}
                                </div>
                            </a>
                        @endif
                        
                        </div>
                        <div class="text-center p-4 bg-gradient position-relative">
                            <h5 class="mb-1">{{ $instructor->name }}</h5>
                            <small class="text-muted">{{ $instructor->skills }}</small>
                            <div class="d-flex justify-content-center mt-3">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Team End -->

<style>
    /* Card Style */
    .team-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .team-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    /* Image Wrapper */
    .image-wrapper {
        width: 100%;
        height: 250px; /* Fixed height for consistent image size */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
    
    .image-wrapper img.instructor-img {
        width: 100%;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }
    
    /* Placeholder Circle */
    .placeholder-circle {
        width: 100px;  /* Fixed width for placeholder */
        height: 100px; /* Fixed height for placeholder */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        color: #ffffff;
        background-color: #6c757d; /* Solid color background */
        border-radius: 50%;
    }
    
    /* Card Content */
    .team-item .bg-light {
        padding: 15px;
        color: #333;
        border-top: 1px solid #eaeaea;
    }
    
    .team-item h5 {
        color: #333;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .team-item small {
        color: #888;
    }
    
    /* Button Styles */
    .team-item .btn {
        border-radius: 25px;
        font-size: 14px;
        padding: 5px 10px;
    }
    
    /* Hover Effects for Buttons */
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }
    
    .btn-outline-primary:hover {
        color: #ffffff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        color: #ffffff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
    </style>
    

@endsection
