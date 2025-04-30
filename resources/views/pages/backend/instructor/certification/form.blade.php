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
                    <form action="{{ route('instructor.certification.store', $course) }}" method="post">
                        @csrf
                        <div class="row">
                            @foreach ($data as $data)
                                <div class="form-group col-md-6">
                                    <label for="score_{{ $data->user->id }}" class="form-label">{{ $data->user->name }}</label>
                                    <input type="number" name="score[{{ $data->user->id }}]" id="" class="form-control" value="{{ number_format($data->average_score, 1) }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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
