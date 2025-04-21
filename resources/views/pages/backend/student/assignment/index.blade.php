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
            @foreach ($data as $data)
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title font-weight-bold mb-0">{{ $data->title }}</h2>
                        <span class="font-weight-bold ml-auto bg-danger text-white px-1">{{ $data->deadline }}</span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! $data->description !!}
                        <a href="{{ asset('storage/materials/' . $data->file_path) }}" class="btn btn-outline-dark">Download File</a>
                        <a href="{{ route('student.assignment.create', [$course, $data->id]) }}" class="btn btn-dark">Create Submission</a>
                    </div>
                </div>
            @endforeach
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
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                }).container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        });
    </script>
@endpush
