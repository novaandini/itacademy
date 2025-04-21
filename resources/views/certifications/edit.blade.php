@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h2 class="text-center mb-5 fw-bold text-primary">Update Certification</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Edit Certification Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('certifications.update', $certification->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Course Selection Field -->
                <div class="mb-3">
                    <label for="course_id" class="form-label">Program</label>
                    <select class="form-select" id="course_id" name="course_id" required>
                        <option disabled>Select Program</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $course->id == $certification->course_id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- User Selection Field -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">Student</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option disabled>Select Student</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $certification->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Certificate Number Field -->
                <div class="mb-3">
                    <label for="certificate_number" class="form-label">Certificate Number</label>
                    <input type="text" class="form-control @error('certificate_number') is-invalid @enderror" 
                           id="certificate_number" name="certificate_number" 
                           value="{{ old('certificate_number', $certification->certificate_number) }}" required>
                    @error('certificate_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" required>{{ old('description', $certification->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date Field -->
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                           id="date" name="date" value="{{ old('date', $certification->date) }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="text-end">
                    <a href="{{ route('certifications.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Certification</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for AJAX (Optional, if needed for dynamic user selection based on course) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#course_id').change(function() {
            let courseId = $(this).val();
            $.ajax({
                url: '{{ route("get.users.by.course") }}',
                method: 'GET',
                data: { course_id: courseId },
                success: function(data) {
                    $('#user_id').empty(); // Clear previous users
                    $('#user_id').append('<option selected disabled>Select User</option>');
                    $.each(data.users, function(key, user) {
                        $('#user_id').append('<option value="' + user.id + '">' + user.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
    </script>
</div>
@endsection
