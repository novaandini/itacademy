@extends('layouts.main')

@section('konten')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm p-4" style="border-radius: 15px; max-width: 600px; width: 100%;">
        <h1 class="mb-4 text-center">Give Feedback</h1>

        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="user_id">Select Student</label>
                <select class="form-control rounded-pill" id="user_id" name="user_id" required>
                    <option value="">-- Select Student --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="comments">Feedback</label>
                <textarea class="form-control" id="comments" name="comments" rows="4" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="rating">Rating (Optional)</label>
                <select class="form-control rounded-pill" id="rating" name="rating">
                    <option value="">-- Select Rating --</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Submit Feedback</button>
                <a href="{{ route('feedback.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>
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
