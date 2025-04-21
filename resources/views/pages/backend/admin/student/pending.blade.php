@extends('layouts.backend.admin')
@section('konten')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Student Validation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Validation</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Student Validation</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.student.validation', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="form-group mb-3 col-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $data->name) }}" disabled>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="form-group mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data->email) }}" disabled>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Profile Image -->
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" id="file" name="file" class="dropify"
                                data-max-file-size="2M" disabled data-allowed-file-extensions="jpg png jpeg"
                                data-default-file="{{ asset('storage/instructors/' . $data->image) }}"
                                data-show-remove="false" />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($data->image != null)
                                <a href="{{ asset('storage/instructors/' . $data->image) }}"><small>Download image</small></a>
                            @endif
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Action</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="validation" id="approveInstructor" value="approved" checked>
                                <label class="form-check-label" for="approveInstructor">
                                Approve
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="validation" id="rejectInstructor" value="rejected">
                                <label class="form-check-label" for="rejectInstructor">
                                Reject
                                </label>
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>
</div>

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Oops, something went wrong'
                },
                error: {
                    'fileSize': 'The file size is too big (max: 2MB).'
                }
            });
        });
    </script>
@endpush


@endsection