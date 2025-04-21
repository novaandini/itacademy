@extends('layouts.main')

@section('konten')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Evaluation List</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('feedback.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus"></i> New Evaluation
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" style="border-radius: 10px; overflow: hidden;">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Student</th>
                        <th>Evaluation</th>
                        <th>Rating</th>
                        <th>Instructor</th>
                        <th>Given On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $feedback)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $feedback->user->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($feedback->comments, 100) }}</td>
                            <td class="text-center">{{ $feedback->rating ?? 'N/A' }}</td>
                            <td>{{ $feedback->admin->name }}</td>
                            <td class="text-center">{{ $feedback->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this feedback?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- Custom CSS for table and buttons -->
    <style>
        /* Table hover effect */
        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
        }

        /* Rounded buttons for actions */
        .btn {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-warning:hover {
            background-color: #ffc107;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-danger:hover {
            background-color: #dc3545;
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
    </style>
@endsection
