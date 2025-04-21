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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Learning Material</h3>

                </div><!-- /.card-header -->
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ $data != null ? route('instructor.learning-materials.update', [$course->id, $data->id]) : route('instructor.learning-materials.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($data)
                            @method('put')
                        @endisset

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="course_id">Select Course</label>
                            <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id" {{ $course ? 'disabled' : 'required' }}>
                                <option value="{{ $course->id }}" selected>{{ $data->course->title ?? $course->title }}</option>
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $data ? old('title', $data->title) : old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ $data ? old('description', $data->description) : old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="file_path">File</label>
                            <input type="file" class="dropify @error('file_path') is-invalid @enderror" 
                            id="file_path" name="file_path" 
                            required accept="image/jpeg, image/png, application/pdf, application/msword, 
                            application/vnd.openxmlformats-officedocument.wordprocessingml.document, 
                            application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg pdf doc docx ppt pptx" data-default-file="{{ $data ? old('file_path', $data->file_path) : old('file_path') }}" data-show-remove="false" />
                            @error('file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @isset($data)
                                <a href="{{ Storage::url($data->file_path) }}" target="_blank" download>
                                    <small>Download File</small>
                                </a>
                            @endisset
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('instructor.learning-materials.index', $course) }}" class="btn btn-secondary">Back</a>
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

<!-- jquery-validation -->
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#description').summernote({
            tabsize: 2,
            height: 100,
            callbacks: {
                onImageUpload: function(files) {
                    alert('Image upload is disabled.');
                }
            },
            disableDragAndDrop: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

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

        // Remove 'required' attribute if a default file is set
        const dropifyInput = document.getElementById('file_path');
        if (dropifyInput.dataset.defaultFile) {
            dropifyInput.removeAttribute('required');
        }
    });
</script>
<script>
    $(function() {
        $.validator.setDefaults({
            submitHandler: function(form) {
                // do other things for a valid form
                form.submit();
            }
        });
        $('.card-body form').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

@endpush

@endsection
