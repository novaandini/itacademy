@extends('layouts.main')

@section('konten')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="border-radius: 15px; max-width: 600px; width: 100%;">
            <h1 class="mb-4 text-center">Edit Assignment</h1>

            <form action="{{ route('instructor.assignments.update', $assignment->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="course_id">Select Course</label>
                    <select class="form-control rounded-pill" name="course_id" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ $assignment->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control rounded-pill" name="title" value="{{ $assignment->title }}"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="4" required>{{ $assignment->description }}</textarea>
                </div>

                <!-- Upload File -->
                <div class="form-group mb-4">
                    <label for="file">Upload New File (optional)</label>
                    <input type="file" class="form-control-file" name="file" accept="image/*,application/pdf">
                    @if ($assignment->file_path)
                        <p class="mt-2">Current file: <a href="{{ asset('storage/' . $assignment->file_path) }}"
                                target="_blank">View File</a></p>
                    @endif
                </div>

                <!-- Deadline -->
                <div class="form-group mb-4">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" class="form-control" name="deadline"
                        value="{{ date('Y-m-d\TH:i', strtotime($assignment->deadline)) }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Update</button>
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
            background-color: #007bff;
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
