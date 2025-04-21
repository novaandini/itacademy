@extends('layouts.main')

@section('konten')

<!-- Student List Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Students</h6>
            <h1 class="mb-3">Our Students</h1>
            <!-- Join Instructor Button -->
            <a href="{{ route('student.signup') }}" class="btn btn-outline-primary mb-5">
                <i class="fas fa-user-plus"></i> Join as Student
            </a>
        </div>
        <div class="row g-4">
            @foreach($students as $student)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light position-relative overflow-hidden shadow-lg rounded-4">
                            <a href="{{ route('student.show', $student->id) }}">
                                <div class="w-100 d-flex justify-content-center align-items-center overflow-hidden position-relative text-center" style="height: 250px;">
                                    @if($student->image)
                                        <img class="img-fluid student-img rounded-top" src="{{ asset('img/' . $student->image) }}" alt="{{ $student->name }}" style="width: 100%; height: 250px; object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center w-100" style="height: 250px; background-color: #e0e0e0;">
                                            <span class="h1 text-secondary">{{ substr($student->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        <div class="text-center p-4">
                            <h5 class="mb-0">{{ $student->name }}</h5>
                            
                            <ul class="list-unstyled">
                                @php
                                    // Collect unique course titles for the student
                                    $uniqueCourses = $student->transactions->flatMap(function ($transaction) {
                                        return $transaction->transactionItems->where('transaction.status', 'settlement')->pluck('course.title');
                                    })->unique();
                                @endphp

                                @if($uniqueCourses->isNotEmpty())
                                    @foreach($uniqueCourses as $courseTitle)
                                        <li>{{ $courseTitle }}</li>
                                    @endforeach
                                @else
                                    <li>N/A</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Student List End -->

@endsection
