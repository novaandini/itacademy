@extends('layouts.main')

@section('konten')
<div class="container">
    <h1 class="mb-4">Submit Assignment: {{ $assignment->title }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('assignments.storeSubmission', $assignment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="answer_text" class="form-label">Answer (Text)</label>
            <textarea class="form-control" id="answer_text" name="answer_text" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label for="answer_file" class="form-label">Answer (File)</label>
            <input type="file" class="form-control" id="answer_file" name="answer_file">
        </div>

        <button type="submit" class="btn btn-primary">Submit Assignment</button>
    </form>
</div>
@endsection
