@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Assignment</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Assignment</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <a href="{{ route('instructor.assignments.create', $module) }}" class="btn btn-success mb-3">New Assignment</a>
                {{-- <a href="{{ route('instructor.submission.index', $module) }}" class="btn btn-success mb-3">Check Submission</a> --}}
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assignment</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Deadline</th>
                                <th>Description</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data)
                                <tr>
                                    <td>{{ $data->title }}</td>
                                    <td>{{ $data->deadline }}</td>
                                    <td>{{ Illuminate\Support\Str::limit(strip_tags($data->description), 50) }}</td>
                                    <td>
                                        @isset($data->file_path)
                                            <a href="{{ $data->file_path }}" class="btn btn-primary btn-sm">Download File</a>
                                        @else
                                            <i>No File</i>
                                        @endisset
                                    </td>
                                    <td class="text-center">
                                        <!-- Approve and Reject buttons -->
                                        <a href="{{ route('instructor.assignments.edit', [$module, $data->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('instructor.assignments.destroy', [$module, $data->id]) }}"
                                            data-id="{{ $data->id }}" method="POST" style="display:inline-block;"
                                            class="delete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('instructor.submission.index', [$module, $data->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Deadline</th>
                                <th>Description</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
        </div>
        </div>
    </section>
</div>

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
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "order": [[2, "desc"]]
            }).container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    });
</script>
@endpush

@endsection
