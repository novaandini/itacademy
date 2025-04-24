@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Certification</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Certification</li>
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
                    @if($data != null)
                        <form action="">
                            
                        </form>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                    <tr>
                                        <td>{{ $data->course->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Program</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
                        </table>                      
                    @endif
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
