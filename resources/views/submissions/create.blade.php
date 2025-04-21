<!-- resources/views/submissions/create.blade.php -->

@extends('layouts.main')

@section('konten')
    <h1>Submit Assignment: {{ $assignment->title }}</h1>
    <form action="{{ route('submissions.store', $assignment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="answer_text">Answer (Text)</label>
            <textarea class="form-control" name="answer_text" id="answer_text" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="answer_file">Upload Answer (File)</label>
            <input type="file" name="answer_file" id="answer_file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit Assignment</button>
    </form>
@endsection
