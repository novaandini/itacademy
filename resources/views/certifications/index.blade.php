@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h2 class="text-center mb-5 fw-bold text-primary">Certifications</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@if(Auth::user()->role == 'Admin')
    <!-- Create Certification Button -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#createCertificationModal">
            <i class="fas fa-plus me-2"></i> Create Certification
        </button>
    </div>

    <!-- Create Certification Modal -->
    <div class="modal fade" id="createCertificationModal" tabindex="-1" aria-labelledby="createCertificationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="createCertificationLabel">Create Certification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('certifications.store') }}" method="POST">
                        @csrf
    
                        <!-- Course Selection Field -->
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Program</label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <option selected disabled>Select Program</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <!-- User Selection Field -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Student</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option selected disabled>Student</option>
                                <!-- Users will be populated here based on the selected course -->
                            </select>
                        </div>
    
                        <!-- Certificate Number Field -->
                        <div class="mb-3">
                            <label for="certificate_number" class="form-label">Certificate Number</label>
                            <input type="text" class="form-control @error('certificate_number') is-invalid @enderror" id="certificate_number" name="certificate_number" placeholder="Enter Certificate Number" required>
                            @error('certificate_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Description Field -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter a brief description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Date Field -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Buttons -->
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Certification</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

<!-- Certifications List -->
<div class="row">
    @foreach($certifications as $certification)
        @if(Auth::user()->role == 'Admin' || Auth::user()->id == $certification->user_id)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow">
                    <div class="card-body d-flex flex-column">
                        <p class="card-text card-title text-primary fw-semibold"><strong>{{ $certification->user->name ?? 'Unknown User' }}</strong></p>
                        <p class="card-text"><strong>Program:</strong> {{ $certification->course->title ?? 'No Course' }}</p>
                        <p class="card-text"><strong>Certificate Number:</strong> {{ $certification->certificate_number ?? 'Not Available' }}</p> <!-- Display Certificate Number -->
                        <p class="card-text"><strong>Date:</strong> {{ $certification->date ?? 'No Date' }}</p>

                        <div class="mt-auto d-flex justify-content-between">
                            @if(Auth::user()->role == 'Admin')
                                <a href="{{ route('certifications.edit', $certification->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i> Update
                                </a>
                            @endif
                            <a href="{{ route('certifications.show', $certification->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if(Auth::user()->role == 'Admin')
                                <form action="{{ route('certifications.destroy', $certification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>


    <!-- JavaScript for AJAX -->
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
