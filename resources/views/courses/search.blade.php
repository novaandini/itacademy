@extends('layouts.main')

@section('konten')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Search Results</h6>
                <h1 class="mb-5">Results for "{{ $query }}"</h1>
                @if ($courses->isEmpty())
                    <p class="mb-4">No program found.</p>
                @endif
            </div>
            <div class="row g-4 justify-content-center">
                <!-- Start of Course Box -->
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light">
                            <div class="position-relative overflow-hidden">
                                <a href="{{ route('detailCourse', $course->id) }}">
                                    <img class="img-fluid course-img" src="{{ asset('assets/img/' . $course->image) }}" alt="{{ $course->title }}">
                                </a>
                                <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                    <a href="{{ route('detailCourse', $course->id) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                    <a href="register" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                                </div>
                                <div class="position-absolute top-0 end-0 mt-3 me-3">
                                    <a href="{{ route('course.edit', $course->id) }}" class="btn btn-sm btn-warning me-2"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('course.destroy', $course->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-center p-4 pb-0">
                                <h3 class="mb-0">${{ number_format($course->price, 2) }}</h3>
                                <div class="mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <small class="fa fa-star {{ $i < $course->rating ? 'text-primary' : 'text-muted' }}"></small>
                                    @endfor
                                    <small>({{ $course->reviews_count }})</small>
                                </div>
                                <h5 class="mb-4">{{ $course->title }}</h5>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor }}</small>
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>{{ $course->duration }}</small>
                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>{{ $course->students }} Students</small>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End of Course Box -->
            </div>
        </div>
    </div>
@endsection
