@extends('layouts.main')

@section('konten')
<div class="container mt-5">
        <h1 class="mb-4 text-center">Assignment List</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('instructor.assignments.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus"></i> New Assignment
            </a>
            <a href="" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-check"></i> Check Submission
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" style="border-radius: 10px; overflow: hidden;">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Deadline</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($assignment->description, 100) }}</td>
                        <td class="text-center">{{ $assignment->deadline }}</td>
                        <td class="text-center">
                            @if($assignment->file_path)
                                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank">View File</a>
                            @else
                                No File
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('instructor.assignments.edit', $assignment->id) }}" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $assignment->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                
                    <!-- Modal for Delete Confirmation -->
                    <div class="modal fade" id="deleteModal-{{ $assignment->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this assignment?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('instructor.assignments.destroy', $assignment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
