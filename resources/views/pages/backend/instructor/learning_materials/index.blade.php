@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Learning Materials</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Learning Materials</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('instructor.learning-materials.create', $course) }}" class="btn btn-success mb-3">Add Data</a>

            <!-- Alert for success message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Learning Materials</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Module</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($learningMaterials as $material)
                                <tr>
                                    <td>{{ $material->title ?? '-' }}</td> <!-- Menampilkan title course dari relasi -->
                                    <td>{{ strip_tags(\Illuminate\Support\Str::limit($material->description, 75)) ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ Storage::url($material->file_path) }}" target="_blank" download class="btn btn-info btn-sm rounded-pill">
                                            Download
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('instructor.learning-materials.edit', [$course, $material->id]) }}" class="btn btn-sm btn-warning me-2"><i class="fa fa-edit"></i></a> 
                                        <form action="{{ route('instructor.learning-materials.destroy', [$course, $material->id]) }}"
                                            data-id="{{ $material->id }}" method="POST" style="display:inline-block;"
                                            class="delete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Module</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('form.delete').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Item ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Kirim formulir
                    } else {
                        Swal.fire('Dibatalkan', 'Penghapusan dibatalkan!', 'info');
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
            }).container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
