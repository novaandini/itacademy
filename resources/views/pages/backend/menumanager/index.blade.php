@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h2 class="text-center mb-4">Menu Manager</h2>

    <!-- Alert for success message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.menumanager.create') }}" class="btn btn-success">Add Data</a>

    <!-- Table to display data data -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $data)
                    <tr>
                        <td>{{ $data->title }}</td>                        
                        <td>{{ ucfirst($data->status) }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.data.show', $data->id) }}" class="btn btn-info">View</a>
                            <!-- Approve and Reject buttons -->
                            <form action="{{ route('admin.data.approve', $data->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm me-2">
                                    <i class="bi bi-check-circle"></i> Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.data.reject', $data->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection