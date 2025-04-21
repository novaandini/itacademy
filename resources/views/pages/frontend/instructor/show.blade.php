@extends('layouts.main')

@section('konten')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="image-frame">
                    <img src="{{ $instructor->image && file_exists(public_path($instructor->image)) ? asset($instructor->image) : asset('images/default-instructor.jpg') }}" 
                         alt="{{ $instructor->name }}" 
                         class="img-fluid rounded">
                </div>
            </div>
            <div class="col-md-6">
                <h1>{{ $instructor->name }}</h1>
                <p><strong>Skills:</strong> {{ $instructor->skills }}</p>
                <p>{{ $instructor->description }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styling -->
<style>
    .image-frame {
        width: 400px; /* Increased width */
        height: 400px; /* Increased height */
        overflow: hidden;
        border: 5px solid #ddd; /* Border for the frame */
        border-radius: 10px; /* Rounded corners */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures image fills frame without distortion */
    }
</style>



@endsection
