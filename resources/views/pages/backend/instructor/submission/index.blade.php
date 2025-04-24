@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Submission</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Submission</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">{{ $title }}</h1>
                </div>
                <div class="card-body">
                    <div class="mb-2" id="userName" style="text-align: right;">
                        <p>Name : {{ Auth::user()->name }}</p> <!-- Nama User -->
                    </div>
            
                    <!-- Tombol Print -->
                    <div class="d-flex justify-content-between mb-4">
                        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
                    </div>
            
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submission as $data)
                                <tr>
                                    <td>{{ $data->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>{{ $data->grade }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('instructor.submission.review', [$course, $data->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Grade</th>
                                <th>Actions</th>
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
