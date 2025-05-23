@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Attendance</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    @if(auth()->user()->role === 'student' || auth()->user()->role === 'instructor')
                        <h3 class="card-title">Attendance</h3>
                    @endif
                </div><!-- /.card-header -->
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(auth()->user()->role === 'student' || auth()->user()->role === 'instructor')
                        <!-- Attendance Form for Student and Instructor -->
                        <form action="{{ route('instructor.attendance.store', $course) }}" method="POST" id="attendance-form">
                            @csrf
                        
                            @if ($hasCourses) <!-- Only show the form if the student has checked out a course -->
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="Present">Present</option>
                                        <option value="Absent">Absent</option>
                                    </select>
                                </div>
                        
                                <div class="form-group mb-3" id="reason-field" style="display: none;">
                                    <label for="reason" class="form-label">Reason (if not present)</label>
                                    <textarea name="reason" class="form-control" id="reason" rows="3"></textarea>
                                </div>
                        
                                <button type="submit" class="btn btn-primary">Submit Attendance</button>
                            @else
                                <p>You need to checkout a course before you can submit attendance.</p>
                            @endif
                        </form>
                    @endif

                    <!-- Attendance Records Section for Admin Only -->
                    @if(auth()->user()->role === 'Admin')
                        <h2 class="mt-4" style="text-align: center">Attendance Records</h2> <br><br>

                        <form method="GET" action="{{ route('attendance.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="date">Filter by Date:</label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="role">Filter by Role:</label>
                                    <select name="role" class="form-select">
                                        <option value="">All</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="course">Filter by Program:</label>
                                    <select name="course" class="form-select">
                                        <option value="">All</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info mt-4">Filter</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Program</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->user->name }}</td>
                                        <td>{{ $attendance->user->transactionItems->first()->course->title ?? '-' }}</td>

                                        <td>{{ $attendance->date }}</td>
                                        <td>{{ $attendance->status }}</td>
                                        <td>{{ $attendance->reason ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('instructor.attendance.download', ['date' => request('date'), 'role' => request('role'), 'course' => request('course')]) }}" class="btn btn-success mt-3">Download Report</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Function to show or hide reason field based on status
    document.getElementById('status').addEventListener('change', function() {
        const reasonField = document.getElementById('reason-field');
        if (this.value === 'Absent') {
            reasonField.style.display = 'block';  // Show reason field if status is 'Tidak Hadir'
        } else {
            reasonField.style.display = 'none';   // Hide reason field if status is 'Hadir'
        }
    });
</script>
@endsection
