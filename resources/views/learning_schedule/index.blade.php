@extends('layouts.main')

@section('konten')
<br><br>
<div class="container">
    @auth
    @if(Auth::user()->role === 'Admin')
    <h2 style="text-align: center">Learning Schedule</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container mt-5">
        <form action="{{ route('learning-schedule.store') }}" method="POST" class="shadow p-4 rounded bg-light">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
    
            <div class="mb-3">
                <label for="course_id" class="form-label">Program</label>
                <select class="form-select" id="course_id" name="course_id" required>
                    <option value="" disabled selected>Select a program</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-3">
                <label for="material" class="form-label">Material</label>
                <textarea class="form-control" id="material" name="material" rows="3"></textarea>
            </div>
    
            <div class="row mb-3">
                <div class="col">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                </div>
                <div class="col">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                </div>
            </div>
    
            <div class="mb-3">
                <label for="instructor_id" class="form-label">Instructor Name</label>
                <select class="form-select" id="instructor_id" name="instructor_id" required>
                    <option value="" disabled selected>Select an instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                    @endforeach
                </select>
            </div>
    
            <button type="submit" class="btn btn-primary">Add Schedule</button>
        </form>
    </div>
    @endif <!-- Close Admin Check -->

    
    <div class="container my-4">
        <h2 class="text-center mb-4">Learning Schedule</h2>
        <!-- Filters and Print Button -->
        <form action="{{ route('learning-schedule.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                @if(Auth::user()->role === 'instructor' || Auth::user()->role === 'Admin')
                <div class="col-md-2">
                    <label for="course_filter" class="form-label fw-bold">Filter by Program</label>
                    <select class="form-select form-select-sm" id="course_filter" name="course_filter" onchange="this.form.submit()">
                        <option value="">All Program</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_filter') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="instructor_filter" class="form-label fw-bold">Filter by Instructor</label>
                    <select class="form-select form-select-sm" id="instructor_filter" name="instructor_filter" onchange="this.form.submit()">
                        <option value="">All Instructors</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ request('instructor_filter') == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-14 text-end">
                    <button onclick="window.print()" class="btn btn-secondary btn-sm">Print Schedule</button>
                </div>
            </div>
        </form>
        @if(Auth::user()->role === 'instructor' || Auth::user()->role === 'student' || Auth::user()->role === 'Admin')
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover shadow-sm" id="scheduleTable">
                <thead class="table-primary text-center">
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
                            <a href="{{ route('learning-schedule.edit', $schedule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('learning-schedule.destroy', $schedule->id) }}" method="POST" class="d-inline">
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
    </div>
    
    
    @endif <!-- Close Role Check -->
    @endauth <!-- Close Auth Check -->
</div>

<style>
    @media print {
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
    }
</style>
@endsection  
