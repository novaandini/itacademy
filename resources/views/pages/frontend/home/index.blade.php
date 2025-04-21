@extends('layouts.main')
@section('konten')
    <!-- Navbar End -->
    <div class="container-fluid p-0 mb-5">
        <div class="position-relative">
            <div style="max-width: 100%; width: 100%; height: 530px; overflow: hidden;">
                <img class="img-fluid w-100" src="assets/img/carousel-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h4 class="display-3 text-white animated slideInDown">Unlock Your Potential with Bali IT Academy!</h4>
                                <p class="fs-5 text-white mb-4 pb-2">Discover your path to a successful tech career with Bali IT 
                                    Academy. Our cutting-edge programs are designed to equip you with the latest skills and 
                                    knowledge in the IT field. Whether you're passionate about coding, cybersecurity, or data 
                                    science, we provide the tools and support to help you achieve your goals. Join a community of 
                                    innovators and start building your future today.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="assets/img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Bali IT Academy</h1>
                    <p class="mb-4">Welcome to Bali IT Academy, the best place to develop your skills in Information 
                        Technology. Whether you are a beginner looking to learn the basics of IT or a professional 
                        looking to deepen your expertise, our courses are designed to meet your needs.</p>
                    <h4 class="mb-4">Our Vision</h4>
                    <p class="mb-4">At Bali IT Academy, our vision is to empower every individual with the knowledge and 
                        skills needed to succeed in the ever-evolving IT world. We are committed to providing high-quality 
                        training that is practical and relevant to today’s industry needs.</p>
                    <h4 class="mb-4">Why Choose Us?</h4>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Customized Program</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Offline Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Flexible Learning</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>National Certificate</p>
                        </div> <br>
                        <h6 class="mb-4">Join Bali IT Academy and take the first 
                            step towards mastering the skills that will shape the future of technology.</h6>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-evenly mt-5">
                <div class="d-flex justify-content-between align-items-end">
                    <h1></h1>
                    <a href="{{ route('course.format') }}" class="fw-bold">Learn more</a>
                </div>
                @foreach ($formats as $format)
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column bg-white shadow-sm rounded-3 overflow-hidden py-4 px-3">
                            <i class="bi bi-archive-fill fs-1 text-primary"></i>
                            <div class="fs-4">
                                {{ $format->title }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="row g-4 justify-content-center mt-5">
                <div class="d-flex justify-content-between align-items-end">
                    <h1>Our Programs</h1>
                    <a href="{{ route('course.join') }}" class="fw-bold">Show more</a>
                </div>
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light shadow-sm rounded overflow-hidden">
                            <div class="position-relative overflow-hidden rounded-top">
                                <a href="{{ route('detailCourse', $course->id) }}" class="d-block">
                                    <img class="img-fluid course-img rounded-top" src="{{ asset('storage/courses/' . $course->image) }}" alt="{{ $course->title }}">
                                    @if($course->discount > 0)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-{{ intval($course->discount) }}%</span>
                                    @endif
                                </a>
                                <div class="position-absolute bottom-0 start-0 end-0 mb-4 d-flex justify-content-center gap-2">
                                    <a href="{{ route('detailCourse', $course->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow">
                                        Learn More
                                    </a>
                                </div>
                                {{-- @auth
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
                                @endauth --}}
                            </div>
                            <div class="text-center p-4">
                                <h4 class="mb-0">
                                    @if($course->discount > 0)
                                        <span class="text-decoration-line-through text-muted currency-price" 
                                              data-idr="{{ number_format($course->price, 0, ',', '.') }}" 
                                              data-usd="{{ number_format($course->price / 17_000, 2) }}">
                                            Rp{{ number_format($course->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-primary ms-2 currency-discounted-price" 
                                              data-idr="{{ number_format($course->discounted_price, 0, ',', '.') }}" 
                                              data-usd="{{ number_format($course->discounted_price / 17_000, 2) }}">
                                            Rp{{ number_format($course->discounted_price, 0, ',', '.') }}
                                        </span>
                                        {{-- <small class="text-danger ms-1">Save {{ intval($course->discount) }}%</small> --}}
                                    @else
                                        <span class="currency-price" 
                                              data-idr="{{ number_format($course->price, 0, ',', '.') }}" 
                                              data-usd="{{ number_format($course->price / 17_000, 2) }}">
                                            Rp{{ number_format($course->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </h4>
                                <div class="mb-3 mt-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <small class="fa fa-star {{ $i < $course->rating ? 'text-primary' : 'text-muted' }}"></small>
                                    @endfor
                                    <small>({{ $course->reviews_count }} Reviews)</small>
                                </div>
                                <h5 class="mb-0 fw-bold title-text-limit">{{ $course->title }}</h5>
                            </div>
                            <div class="d-flex border-top text-center">
                                <small class="flex-fill p-3 col-lg-4 text-truncate d-block border-end">
                                    <i class="fa fa-user-tie text-primary me-1"></i>{{ $course->user->name }}
                                </small>
                                <small class="flex-fill p-3 col-lg-4 text-truncate d-block border-end">
                                    <i class="fa fa-clock text-primary me-1"></i>{{ $course->duration }}
                                </small>
                                <small class="flex-fill p-3 col-lg-4 text-truncate d-block">
                                    <i class="fa fa-user text-primary me-1"></i>{{ $course->capacity }} Students
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>    
    </div>    

@endsection

@if (session('success'))
    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    });
    </script>
    @endpush
@endif

@push('style')
<style>
    .title-text-limit {
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Maksimal 2 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
@endpush
