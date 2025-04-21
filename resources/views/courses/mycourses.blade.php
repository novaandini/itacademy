@extends('layouts.main')

@section('konten')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Our Programs</h6>
                <h1 class="mb-5">Explore Our Courses</h1>
                @auth
                @if(Auth::user()->role === 'instructor' || Auth::user()->role === 'Admin')
                    <a href="{{ route('course.create') }}" class="btn btn-primary mb-4">
                        <i class="fas fa-plus"></i> Add Course
                    </a>
                @endif
                @endauth
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light shadow-sm rounded">
                            <div class="position-relative overflow-hidden rounded-top">
                                <a href="{{ route('detailCourse', $course->id) }}" class="d-block">
                                    <img class="img-fluid course-img rounded-top" src="{{ asset('assets/img/' . $course->image) }}" alt="{{ $course->title }}">
                                    @if($course->discount > 0)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-{{ intval($course->discount) }}%</span>
                                    @endif
                                </a>
                                <div class="position-absolute bottom-0 start-0 end-0 mb-4 d-flex justify-content-center gap-2">
                                    <a href="{{ route('detailCourse', $course->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow">
                                        Learn More
                                    </a>
                                </div>
                                @auth
                                @if(Auth::user()->role === 'instructor' || Auth::user()->role === 'Admin')
                                    <div class="position-absolute top-0 end-0 mt-3 me-3 d-flex">
                                        <a href="{{ route('course.edit', $course->id) }}" class="btn btn-sm btn-warning me-2"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('course.destroy', $course->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                @endif
                                @endauth
                            </div>
                            <div class="text-center p-4 pb-0">
                                @if($course->discount > 0)
                                    <h3 class="mb-0">
                                        <span class="text-decoration-line-through text-muted">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                        <span class="text-primary ms-2">Rp{{ number_format($course->discounted_price, 0, ',', '.') }}</span>
                                        <small class="text-danger ms-1">Save {{ intval($course->discount) }}%</small>
                                    </h3>
                                @else
                                    <h3 class="mb-0">Rp{{ number_format($course->price, 0, ',', '.') }}</h3>
                                @endif
                                <div class="mb-3 mt-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <small class="fa fa-star {{ $i < $course->rating ? 'text-primary' : 'text-muted' }}"></small>
                                    @endfor
                                    <small>({{ $course->reviews_count }} Reviews)</small>
                                </div>
                                <h5 class="mb-4 fw-bold">{{ $course->title }}</h5>
                            </div>
                            <div class="d-flex border-top text-center">
                                <small class="flex-fill py-3 border-end">
                                    <i class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor }}
                                </small>
                                <small class="flex-fill py-3 border-end">
                                    <i class="fa fa-clock text-primary me-2"></i>{{ $course->duration }}
                                </small>
                                <small class="flex-fill py-3">
                                    <i class="fa fa-user text-primary me-2"></i>{{ $course->students }} Students
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $courses->links('pagination') }}
            </div>
        </div>
    </div>
@endsection
