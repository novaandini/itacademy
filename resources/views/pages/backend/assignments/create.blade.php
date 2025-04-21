@extends('layouts.backend.admin')

@section('konten')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm p-4" style="border-radius: 15px; max-width: 600px; width: 100%;">
        <h1 class="mb-4 text-center">Create New Assignment</h1>

        <form action="{{ route('instructor.assignments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="course_id">Select Course</label>
                <select class="form-control rounded-pill" name="course_id" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" class="form-control rounded-pill" name="title" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>

            <!-- Upload File -->
            <div class="form-group mb-4">
                <label for="file">Upload File (optional)</label>
                <input type="file" class="form-control-file" name="file" accept="image/*,application/pdf">
            </div>

            <!-- Deadline -->
            <div class="form-group mb-4">
                <label for="deadline">Deadline</label>
                <input type="datetime-local" class="form-control" name="deadline" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Save</button>
                <a href="{{ route('instructor.assignments.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Custom CSS for form and buttons -->
<style>
    .form-control {
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn-primary {
        border: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary:hover {
        background-color: #6c757d;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .card {
        border-radius: 15px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>

@endsection
