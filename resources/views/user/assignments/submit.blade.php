@extends('layouts.main')

@section('konten')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm p-4" style="border-radius: 15px; max-width: 600px; width: 100%;">

        <!-- Pilihan untuk memilih text atau file -->
        <div class="form-group mb-4">
            <label for="submission_type">Select Submission Type:</label>
            <select class="form-control rounded-pill" id="submission_type" name="submission_type" onchange="toggleInput()">
                <option value="">-- Choose Submission Type --</option>
                <option value="text">Submit Text</option>
                <option value="file">Submit File</option>
            </select>
        </div>

        <form action="{{ route('user.assignments.store', $assignment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Input for Text Submission -->
            <div class="form-group mb-3" id="text_input" style="display: none;">
                <label for="answer_text">Answer (Text)</label>
                <textarea class="form-control" name="answer_text" rows="4" placeholder="Type your answer here..."></textarea>
            </div>

            <!-- Input for File Submission -->
            <div class="form-group mb-4" id="file_input" style="display: none;">
                <label for="answer_file">Answer (File)</label>
                <input type="file" class="form-control rounded-pill" name="answer_file">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Submit</button>
                <a href="{{ route('user.assignments.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Custom CSS -->
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
        background-color: #1554db;
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

<!-- JavaScript to toggle input fields based on selection -->
<script>
    function toggleInput() {
        var submissionType = document.getElementById('submission_type').value;
        var textInput = document.getElementById('text_input');
        var fileInput = document.getElementById('file_input');

        if (submissionType === 'text') {
            textInput.style.display = 'block';
            fileInput.style.display = 'none';
        } else if (submissionType === 'file') {
            textInput.style.display = 'none';
            fileInput.style.display = 'block';
        } else {
            textInput.style.display = 'none';
            fileInput.style.display = 'none';
        }
    }
</script>

@endsection
