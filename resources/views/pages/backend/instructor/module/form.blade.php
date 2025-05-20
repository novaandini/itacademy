@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Module</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Module</li>
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
                    <h3 class="card-title">Form Module</h3>

                </div><!-- /.card-header -->
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('instructor.module.update', [$course, $data->module_id]) }}" method="POST" enctype="multipart/form-data">
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

                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label for="learning_objectives">Learning Objectives</label>
                                <input type="text" name="learning_objectives" id="" class="form-control" value="{{ $data ? old('learning_objectives', $data->learning_objectives) : old('learning_objectives') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="content">Content/Material</label>
                                <input type="text" name="content" id="" class="form-control" value="{{ $data ? old('content', $data->content) : old('content') }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="duration_hours">Duration (hours)</label>
                                <input type="number" name="duration_hours" value="{{ $data ? old('duration_hours', $data->duration_hours) : old('duration_hours') }}" min="1" max="100" id="" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="activities">Activities</label>
                                <input type="text" name="activities" id="" class="form-control" value="{{ $data ? old('activities', $data->activities) : old('activities') }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="assessment_type">Assessment Type</label>
                                <input type="text" name="assessment_type" id="" class="form-control" value="{{ $data ? old('assessment_type', $data->assessment_type) : old('assessment_type') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="passing_grade">Passing Grade (%)</label>
                                <input type="number" name="passing_grade" min="1" max="100" id="" class="form-control" value="{{ $data ? old('passing_grade', $data->passing_grade) : old('passing_grade') }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="status">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option value="draft" {{ (old('status') ?? $data->module_status == 'draft') ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ (old('status') ?? $data->module_status == 'published') ? 'selected' : '' }}>Published</option>
                                    <option value="unpublished" {{ (old('status') ?? $data->module_status == 'unpublished') ? 'selected' : '' }}>Unpublished</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="resources">Resources</label>
                                <input type="text" name="resources" id="" class="form-control" value="{{ $data ? old('resources', $data->resources) : old('resources') }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="prerequisites">Prerequisites</label>
                                <input type="text" name="prerequisites" id="" class="form-control" value="{{ $data ? old('prerequisites', $data->prerequisites) : old('prerequisites') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('instructor.module.index', $course) }}" class="btn btn-secondary">Back</a>
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
