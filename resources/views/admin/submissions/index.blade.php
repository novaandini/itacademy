@extends('layouts.main')

@section('konten')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <!-- Back button -->
            <a href="{{ url('/admin/assignments') }}">
                <i class="fas fa-arrow-left me-2"></i>back
            </a>
            <h1 class="mb-0 text-center flex-grow-1">Review Submissions</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" style="border-radius: 10px; overflow: hidden;">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Assignment</th>
                        <th>Answer</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $submission)
                        <tr>
                            <td>{{ $submission->user->name }}</td>
                            <td>{{ $submission->assignment->title }}</td>
                            <td>
                                @if ($submission->answer_text)
                                    <p>{{ \Illuminate\Support\Str::limit($submission->answer_text, 100) }}</p>
                                @endif
                                @if ($submission->answer_file)
                                    <a href="{{ Storage::url($submission->answer_file) }}"
                                        class="btn btn-info btn-sm rounded-pill">Download File</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($submission->grade)
                                    <span class="badge bg-success">{{ $submission->grade }}</span>
                                @else
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#gradeModal-{{ $submission->id }}">
                                        Give Grade
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="gradeModal-{{ $submission->id }}" tabindex="-1"
                                        aria-labelledby="gradeModalLabel-{{ $submission->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gradeModalLabel-{{ $submission->id }}">Give
                                                        Grade to {{ $submission->user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.submissions.grade', $submission->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="grade">Grade</label>
                                                            <input type="number" class="form-control rounded-pill"
                                                                name="grade" placeholder="Enter grade" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        /* Table hover effect */
        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
        }

        /* Rounded buttons for actions */
        .btn {
            transition: all 0.3s ease;
        }

        .btn-primary,
        .btn-info {
            border-radius: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-info:hover {
            background-color: #17a2b8;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Card customization */
        .card {
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Table styling */
        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead th {
            text-align: center;
        }

        tbody td {
            vertical-align: middle;
        }

        .badge {
            font-size: 1.1em;
            padding: 0.5em;
            border-radius: 10px;
        }
    </style>
@endsection
