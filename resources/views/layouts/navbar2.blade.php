<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <div class="container-fluid px-4 px-lg-5">
        <!-- Logo -->
        <a href="{{ url('/course') }}" class="navbar-brand d-flex align-items-center">
            <h2 class="p-0 text-primary">
                <img src="{{ asset('assets/img/bitac.png') }}" alt="Logo" width="150" height="75">
            </h2>
        </a>

        <!-- Search Box -->
        <form class="d-flex ms-3" action="{{ url('/search') }}" method="GET" style="flex-grow: 1; max-width: 300px;">
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <!-- Navbar Menu Items -->
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            @if (Auth::user()->role === 'student')
                <a href="{{ url('/my-courses') }}" class="nav-item nav-link">My Courses</a>
                <a href="{{ url('/cart') }}" class="nav-item nav-link" style="position: relative;">
                    <i class="fa fa-shopping-cart"></i>
                    Cart
                    @if (session()->has('cart'))
                        <span class="badge rounded-pill bg-danger position-absolute" style="top: 11px; right: 47px;">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            @endif
            @if (Auth::user()->role === 'instructor')
                <a href="{{ url('/mycourses') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">My Courses</a>
                <a href="{{ route('instructor.course.index') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">Dashboard</a>
            @elseif (Auth::user()->role === 'Admin')
                {{-- <a href="{{ route('') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">Dashboard</a> --}}
            @elseif (Auth::user()->role == 'student')
                <a href="{{ route('student.dashboard.index') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">Dashboard</a>
            @endif


            <!-- Profile Button -->
<!-- Profile Button -->
<button class="btn nav-link d-flex align-items-center p-0 border-0" data-bs-toggle="offcanvas"
    data-bs-target="#sidebarProfile">
    @php
        $profileImage = null;
        
        // Check if user is an instructor with approved status
        if (Auth::user()->role === 'instructor') {
            $instructor = \App\Models\User::where('email', Auth::user()->email)
                                                ->where('status', 'approved')
                                                ->first();
            $profileImage = $instructor ? $instructor->image : null;
        }
    @endphp

    @if ($profileImage)
        <!-- Display instructor's profile picture if approved and available -->
        <img src="{{ asset($profileImage) }}" alt="Instructor Profile" class="rounded-circle"
             width="40" height="40">
    @elseif (Auth::user()->image)
        <!-- Otherwise, display user image from the users table -->
        <img src="{{ asset('storage/instructors/' . Auth::user()->image) }}" alt="User Profile" class="rounded-circle"
             width="40" height="40">
    @else
        <!-- Placeholder with the user's initial if no image is available -->
        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
             style="width: 40px; height: 40px;">
            {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
        </div>
    @endif
</button>

        </div>
    </div>
</nav>
