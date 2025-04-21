@extends('layouts.main')

@section('konten')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-title bg-white text-center text-primary px-3">Add Program</h6>
            <h1 class="mb-5">Add New Program</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Add Program</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Program Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Program Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter program title" required>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter program price" required>
                    </div>

                    <!-- Discount -->
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter program discount (optional)" min="0" max="100">
                    </div>

                    <!-- Program Duration -->
                    <div class="mb-3">
                        <label for="duration" class="form-label">Program Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter program duration" required>
                    </div>

                    <!-- Number of Students -->
                    <div class="mb-3">
                        <label for="students" class="form-label">Number of Students</label>
                        <input type="number" class="form-control" id="students" name="students" placeholder="Enter number of students" required>
                    </div>

                    <!-- Program Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Program Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <!-- Program Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter program description" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Add Program</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
