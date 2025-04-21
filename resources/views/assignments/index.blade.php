@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm p-4" style="border-radius: 15px;">
        <h1 class="mb-4 text-center">Assignments</h1>
        <a href="{{ route('assignments.create') }}" class="btn btn-primary rounded-pill px-4 mb-4">Create New Assignment</a>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle" style="border-radius: 10px; overflow: hidden;">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Duration (days)</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($assignment->description, 100) }}</td>
                        <td class="text-center">{{ $assignment->duration }}</td>
                        <td class="text-center">
                            <a href="{{ route('assignments.show', $assignment->id) }}" class="btn btn-info btn-sm rounded-pill">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Table hover effect */
    .table-hover tbody tr:hover {
        background-color: #f2f2f2;
    }

    /* Rounded buttons for actions */
    .btn {
        transition: all 0.3s ease;
    }

    .btn-info, .btn-primary {
        border-radius: 20px;
    }

    .btn-info:hover {
        background-color: #17a2b8;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
        background-color: #0056b3;
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
