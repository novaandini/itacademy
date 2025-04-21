@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h2 class="mb-4" style="text-align: center">Update Learning Schedule</h2>
    <form action="{{ route('learning-schedule.update', $schedule->id) }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        @method('POST')
        
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
            <input class="form-control" type="date" id="date" name="date" value="{{ $schedule->date }}" required> 
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Program</label>
            <select class="form-select" id="course_id" name="course_id" required>
                <option value="" disabled>Select a program</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $schedule->course_id == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="material" class="form-label">Material</label>
            <textarea class="form-control" id="material" name="material" rows="3">{{ $schedule->material }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $schedule->start_time }}" required>
            </div>
            <div class="col">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $schedule->end_time }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="instructor_id" class="form-label">Instructor Name</label>
            <select class="form-select" id="instructor_id" name="instructor_id" required>
                <option value="" disabled>Select an instructor</option>
                @foreach($instructors as $instructor)
                    <option value="{{ $instructor->id }}" {{ $schedule->instructor_id == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Schedule</button>
    </form>
</div>
@endsection
