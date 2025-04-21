@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Learning Materials Data</h1>
    
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.learning-materials.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus"></i> Add
        </a>
    </div>

    @if($learningMaterials->isNotEmpty())
        <table class="table table-hover table-bordered table-bordered align-middle" id="learningMaterialTable">
            <thead class="bg-primary text-white">
                <tr class="text-center">
                    <th scope="col" class="text-center">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Course Title</th> <!-- Kolom baru untuk title course -->
                    <th scope="col">Description</th>
                    <th scope="col">Module</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($learningMaterials as $index => $material)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $material->title ?? '-' }}</td>
                        <td>{{ $material->course->title ?? '-' }}</td> <!-- Menampilkan title course dari relasi -->
                        <td>{{ \Illuminate\Support\Str::limit($material->description, 100) ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" download class="btn btn-info btn-sm rounded-pill">
                                Download
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.learning-materials.edit', $material->id) }}" class="btn btn-sm btn-warning me-2"><i class="fa fa-edit"></i></a> 
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                onclick="setDeleteAction('{{ route('admin.learning-materials.destroy', $material->id) }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info text-center">No learning materials found.</div>
    @endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this learning material?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Custom CSS to enhance the table and print styling -->
<style>
    /* Print styling */
    @media print {
        body * {
            visibility: hidden;
        }

        #learningMaterialTable, #learningMaterialTable * {
            visibility: visible;
        }

        #learningMaterialTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }

    /* Table hover effect */
    .table-hover tbody tr:hover {
        background-color: #f2f2f2;
    }

    /* Table customization */
    .table {
        border-radius: 10px;
        overflow: hidden;
        background-color: white;
    }

    /* Rounded buttons for actions */
    .btn {
        transition: all 0.3s ease;
    }

    .btn-info, .btn-primary, {
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

    .btn-danger:hover {
        background-color: #dc3545;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Adding shadow and border radius to the table container */
    .table-responsive {
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Aligning table header and rows for a cleaner look */
    thead th {
        text-align: center;
    }

    tbody td {
        vertical-align: middle;
    }
</style>

<script>
    function setDeleteAction(url) {
        document.getElementById('deleteForm').action = url;
    }
</script>

@endsection
