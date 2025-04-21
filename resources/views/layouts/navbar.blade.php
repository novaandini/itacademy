<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="p-0 text-primary"><img src="{{ asset('assets/img/bitac.png') }}" alt="" width="150" height="75"></h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ route('home') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
            <!--<a href="{{ route('course.join') }}" class="nav-item nav-link {{ Request::is('courses') ? 'active' : '' }}">Program</a>-->
            <div class="btn-group d-none d-lg-block">
                <a type="button" class="btn dropdown-toggle nav-item nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                    Program
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item text-dark" href="{{ route('course.format') }}">Course Format</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-dark" href="{{ route('course.program') }}">Course Program</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-dark" href="{{ route('course.join') }}">Join the Course</a>
                    </li>
                </ul>
            </div>
            <a href="{{ url('/instructor') }}" class="nav-item nav-link {{ Request::is('instructor') ? 'active' : '' }}">Instructor</a>
            <a href="{{ url('/student') }}" class="nav-item nav-link {{ Request::is('student') ? 'active' : '' }}">Student</a>
            <a href="{{ route('news-event.index') }}" class="nav-item nav-link {{ Request::is('news-event') ? 'active' : '' }}">News & Event</a>
            @auth
                @if (Auth::user()->role === 'instructor')
                    <a href="{{ url('/mycourses') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">My Courses</a>
                    <a href="{{ route('instructor.course.index') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">Dashboard</a>
                @elseif (Auth::user()->role === 'Admin')
                    <a href="{{ route('admin.news.index') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">Dashboard</a>
                @elseif (Auth::user()->role == 'student')
                    <a href="{{ route('student.dashboard.index') }}" class="nav-item nav-link {{ Request::is('mycourses') ? 'active' : '' }}">Dashboard</a>
                @endif
            @endauth
        </div>
        @auth
            <div class="btn-group d-none d-lg-block">
                <button type="button" class="btn " data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('storage/instructors/' . Auth::user()->image ?? 'default.jpg') }}" alt="User Profile" class="rounded-circle" width="40" height="40">
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark w-100 py-2">
                                <i class="fa fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ url('/login') }}" class="btn btn-primary py-4 px-lg-4 d-none d-lg-block {{ Request::is('login') ? 'active' : '' }}">Login</a>
            <!-- Register Dropdown -->
            <div class="btn-group d-none d-lg-block">
                <button type="button" class="btn btn-secondary dropdown-toggle py-4 px-lg-4" data-bs-toggle="dropdown" aria-expanded="false">
                    Register
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('instructor.register') }}">Instructor</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('student.signup') }}">Student</a>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
