<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/img/bitac.png') }}" alt="IT Academy Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">IT Academy</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        @auth
            <!-- Sidebar user panel (optional) -->
            <a href="{{ url('/profile') }}">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('storage/instructors/' . (Auth::user()->image ?? 'default.jpg')) }}"
                            alt="User Profile Picture" class="img-circle elevation-2">
                    </div>
                    <div class="info">
                        <span class="d-block">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </a>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                                                       with font-awesome or any other icon font library -->
                    @if (Auth::user()->role === 'Admin')
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Settings
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./index.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>General manager</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./index2.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Menu Manager</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Program
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.course-format.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Course Format</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pages/charts/flot.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Course Category</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Courses
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.course.pending') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Course Validation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    Instructor
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.instructor.pending') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Instructors Validation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.instructor.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Instructor</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    News & Event
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.news.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>News & Event</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-image"></i>
                                <p>
                                    Gallery
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="pages/forms/general.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Photo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pages/forms/advanced.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Video</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>
                                    Extra
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="pages/tables/simple.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Social Media</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pages/tables/data.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Contact Us</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Partners & Clients
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>
                                    Reviews
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Accounts
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Student
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.student.pending') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Students Validation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('students.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Student</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.learning-materials.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Learning Material
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.attendance.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-calendar-check"></i>
                                <p>
                                    Attendance
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.learning-schedule.index') }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Learning Schedule
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('certifications.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-certificate"></i>
                                <p>
                                    Certification
                                </p>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role === 'instructor')
                        <li class="nav-item">
                            <a href="{{ route('instructor.course.index') }}" class="nav-link">
                                <i class="fas fa-book-open nav-icon"></i>
                                <p>Your Courses</p>
                            </a>
                        </li>
                        @foreach ($courses as $data)
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>
                                        {{ $data->title }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('instructor.student.index', $data->id) }}" class="nav-link">
                                            <i class="fa fa-users nav-icon"></i>
                                            <p>Student</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('instructor.learning-schedule.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon far fa-calendar-alt"></i>
                                            <p>
                                                Learning Schedule
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('instructor.attendance.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-calendar-check"></i>
                                            <p>
                                                Attendance
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('instructor.learning-materials.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                Learning Material
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('instructor.assignments.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-check-square"></i>
                                            <p>
                                                Assignment
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="nav-icon fa fa-certificate"></i>
                                            <p>Certification</p>
                                        </a>
                                    </li>
                                    <!--<li class="nav-item">-->
                                    <!--    <a href="{{ url('/feedback', $data->id) }}" class="nav-link">-->
                                    <!--        <i class="nav-icon fa fa-chart-bar"></i>-->
                                    <!--        <p>-->
                                    <!--            Evaluation-->
                                    <!--        </p>-->
                                    <!--    </a>-->
                                    <!--</li>-->
                                </ul>
                            </li>
                        @endforeach
                    @endif
                    @if ( Auth::user()->role === 'student')
                        <li class="nav-item">
                            <a href="{{ route('student.dashboard.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @foreach ($courses as $data)
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>
                                        {{ $data->title }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('student.attendance.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-calendar-check"></i>
                                            <p>
                                                Attendance
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('student.schedule.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon far fa-calendar-alt"></i>
                                            <p>
                                                Learning Schedule
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('student.material.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-calendar-check"></i>
                                            <p>
                                                Learning Material
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('student.assignment.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-check-square"></i>
                                            <p>
                                                Assignments
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('student.evaluation.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-chart-bar"></i>
                                            <p>
                                                Evaluation
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('student.certification.index', $data->id) }}" class="nav-link">
                                            <i class="nav-icon fa fa-certificate"></i>
                                            <p>
                                                Certification
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        @endauth
    </div>
    <!-- /.sidebar -->
</aside>
