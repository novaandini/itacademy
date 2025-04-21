@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Learning Schedule</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Learning Schedule</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Learning Schedule</h3>
                </div>
                <div class="card-body">
                    <!-- Filters and Print Button -->
                    <form action="{{ route('instructor.learning-schedule.index', $course) }}" method="GET" class="mb-4">
                        <div class="row align-items-end">
                            @if(Auth::user()->role === 'Admin')
                                <div class="col-md-2">
                                    <label for="course_filter" class="form-label fw-bold">Filter by Program</label>
                                    <select class="form-control" id="course_filter" name="course_filter" onchange="this.form.submit()">
                                        <option value="">All Program</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_filter') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="instructor_filter" class="form-label fw-bold">Filter by Instructor</label>
                                    <select class="form-control" id="instructor_filter" name="instructor_filter" onchange="this.form.submit()">
                                        <option value="">All Instructors</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ request('instructor_filter') == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if (Auth::user()->role === 'instructor' || Auth::user()->role === 'Admin')
                                <div class="col-md-6">
                                    <a href="{{ route('instructor.learning-schedule.create', $course) }}" class="btn btn-primary w-full">Create Data</a>
                                    <button onclick="window.print()" class="btn btn-secondary">Print Schedule</button>
                                </div>
                            @endif
                            <div class="col-md-2 d-flex justify-content-end">
                            </div>
                        </div>
                    </form>
                    @if(Auth::user()->role === 'instructor' || Auth::user()->role === 'student' || Auth::user()->role === 'Admin')
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-bordered align-middle" id="scheduleTable">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Date</th>
                                        <th>Program</th>
                                        <th>Material</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Instructor Name</th>
                                        @if(Auth::user()->role === 'Admin')
                                        <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat("l, d F Y") }}</td>
                                            <td>{{ $schedule->course->title }}</td>
                                            <td>{{ $schedule->material }}</td>
                                            <td>{{ $schedule->start_time }}</td>
                                            <td>{{ $schedule->end_time }}</td>
                                            <td>{{ $schedule->instructor->name }}</td>
                                            @if(Auth::user()->role === 'Admin')
                                                <td>
                                                    <a href="{{ route('instructor.learning-schedule.edit', $schedule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('instructor.learning-schedule.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif <!-- Close Role Check -->
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* @media print {
        body * {
            visibility: hidden;
        }
        #scheduleTable, #scheduleTable * {
            visibility: visible;
        }
        #scheduleTable {
            position: absolute;
            left: 0;
            top: 0;
        }
        #scheduleTable th:last-child, #scheduleTable td:last-child {
            display: none;
        }
    } */
</style>
@endsection  
