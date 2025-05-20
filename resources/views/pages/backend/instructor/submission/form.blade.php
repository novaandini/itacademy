@extends('layouts.backend.admin')
@section('konten')

<div class="content-wrapper">
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
                    <h3 class="card-title">{{ $title }}</h3>
                </div>

                @if (session('error'))
                    {{ session('error') }}
                @endif
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('instructor.submission.store', [$module, $data->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    
                        <!-- Full Name -->
                        <div class="row">
                            <div class="form-group mb-3 col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $data->user->name) }}" disabled>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $data->user->phone) }}" readonly>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <!-- Email -->
                            <div class="form-group mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data->user->email) }}" readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="answer_text" class="form-label">Answer</label>
                            <textarea name="answer_text" id="description" class="form-control @error('answer_text') is-invalid @enderror" placeholder="A brief summary about yourself" rows="3">{{ old('answer_text', $data->answer_text) }}</textarea>
                            @error('answer_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- File Upload -->
                        <div class="form-group mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" id="file" name="file" class="dropify"
                                data-max-file-size="2M" disabled data-allowed-file-extensions="jpg png jpeg" @isset($data->file) data-default-file="{{ asset('storage/cvs/' . ($data ? old('file', $data->file) : old('file'))) }}" @endisset data-show-remove="false" />
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @isset($data->file)
                                <a href="{{ asset('storage/cvs/' . $data->file) }}" target="_blank"><small>Download File</small></a>
                            @endisset
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="number" name="grade" id="grade" class="form-control @error('grade') is-invalid @enderror" value="{{ old('grade', $data->user->grade) }}" min="0" max="100">
                        </div>

                        <div class="form-group mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea name="feedback" id="feedback" class="form-control @error('feedback') is-invalid @enderror" rows="3">{{ old('feedback', $data->feedback) }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
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
            $('#feedback').summernote({
                tabsize: 2,
                height: 100,
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0]); // Pass the uploaded file to the upload function
                    }
                }
            });
            $('#description').summernote({
                tabsize: 2,
                height: 100,
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0]); // Pass the uploaded file to the upload function
                    }
                }
            });
            $('#description').summernote('disable');
            
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

            document.querySelectorAll('.dropify').forEach(input => {
                if (input.dataset.defaultFile) {
                    input.removeAttribute('readonly');
                }
            });
        });
    </script>
@endpush


@endsection