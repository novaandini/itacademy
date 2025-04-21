@extends('layouts.main')

@section('konten')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm p-4" style="max-width: 600px; width: 100%; border-radius: 15px;">
        <h2 class="mb-4 text-center">Edit Learning Material</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('learning-materials.update', $learningMaterial->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="title">Title:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $learningMaterial->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description', $learningMaterial->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="file_path">File (Module):</label>
                <input type="file" class="form-control @error('file_path') is-invalid @enderror" id="file_path" name="file_path">
                @error('file_path')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if($learningMaterial->file_path)
                    <p class="mt-2">Current File: <a href="{{ Storage::url($learningMaterial->file_path) }}" target="_blank" download>Download File</a></p>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                <a href="{{ route('learning-materials.index') }}" class="btn btn-secondary rounded-pill px-4">Back</a>
            </div>
        </form>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        background-color: #f9f9f9;
    }

    .form-control {
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        border: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }
</style>
@endsection
