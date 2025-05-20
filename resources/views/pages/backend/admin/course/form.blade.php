@extends('layouts.backend.admin')

@section('konten')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="height: 100vh">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Course List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Course List</li>
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
                        <h3 class="card-title">Form New Course</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.course.validation', $data->id) }}"
                            method="POST" enctype="multipart/form-data" class="custom-validation">
                            @csrf

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $data ? old('title', $data->title) : old('title') }}" required>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" placeholder="Enter program price" value="{{ $data ? old('price', $data->price) : old('price') }}" required>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter program discount (optional)" min="0" value="{{ $data ? old('discount', $data->discount) : old('discount') }}" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $data ? old('start_date', $data->start_date) : old('start_date') }}" required>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $data ? old('end_date', $data->end_date) : old('end_date') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="course_format_id" class="form-label">Course Format</label>
                                    <select class="form-control" aria-label="None" name="course_format_id" required>
                                        {{-- <option value="">None</option> --}}
                                        @foreach ($formats as $formats)
                                            <option value="{{ $formats->id }}"
                                                {{ ($data ? old('course_format_id', $data->course_format_id) : old('course_format_id')) == $formats->id ? 'selected' : '' }}>
                                                {{ $formats->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="course_categories_id" class="form-label">Course Program</label>
                                    <select class="form-control" aria-label="None" name="course_categories_id" required>
                                        {{-- <option value="">None</option> --}}
                                        @foreach ($programs as $programs)
                                            <option value="{{ $programs->id }}"
                                                {{ ($data ? old('course_categories_id', $data->course_categories_id) : old('course_categories_id')) == $programs->id ? 'selected' : '' }}>
                                                {{ $programs->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Number of Students -->
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Number of Students</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter number of students" value="{{ $data ? old('capacity', $data->capacity) : old('capacity') }}" required>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control description" required>{{ $data ? old('description', $data->description) : old('description') }}</textarea>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="image" class="form-label">Program Image</label>
                                    <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg" class="dropify"
                                        data-max-file-size="2M" required data-allowed-file-extensions="jpg png jpeg"
                                        data-default-file="{{ asset('storage/courses/' . ($data ? old('image', $data->image) : old('image'))) }}"
                                        data-show-remove="false" />
                                    <small>note: Ukuran gambar maksimal 2MB (.png, .jpg, .jpeg)</small>
                                </div>
                            </div>

                            <div class="" id="moduleContainer">
                                <hr>
                                <div class="h3 text-center">Course Module</div>
                                @foreach ($modules as $module)
                                <div class="p-3 border border-dark border-2 mb-3">
                                    <div class="row">
                                        <div class="form-group mb-3 col-md-12">
                                            <label for="module_titles">Module Title</label>
                                            <input type="text" name="module_titles[]" id="" class="form-control" value="{{ $module->title ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group mb-3 col-md-12">
                                            <label for="module_descriptions">Module Description</label>
                                            <textarea name="module_descriptions" cols="30" rows="10" class="form-control description" required>{{ $module->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    
                                    @if($module->learning_objectives != null)
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-12">
                                                <label for="module_objectives">Learning Objectives</label>
                                                <input type="text" name="module_objectives[]" id="" class="form-control" value="{{ $module->learning_objectives ?? '' }}">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($module->content != null || $module->duration != 0)
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_contents">Content/Material</label>
                                                <input type="text" name="module_contents[]" id="" class="form-control" value="{{ $module->content ?? '' }}">
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_durations">Duration (hours)</label>
                                                <input type="number" name="module_durations[]" value="{{ $module->duration_hours ?? 0 }}" min="1" max="100" id="" class="form-control">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($module->activities != null || $module->assessment_types != null)
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_activities">Activities</label>
                                                <input type="text" name="module_activities[]" id="" class="form-control" value="{{ $module->activities ?? '' }}">
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_assesssment_types">Assessment Type</label>
                                                <input type="text" name="module_assesssment_types[]" id="" class="form-control" value="{{ $module->assessment_type ?? '' }}">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if ($module->passing_grade != 0 || $module->module_status != null)
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_passing_grades">Passing Grade (%)</label>
                                                <input type="number" name="module_passing_grades[]" min="1" max="100" value="{{ $module->passing_grade ?? 0 }}" id="" class="form-control">
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_status">Status</label>
                                                <select name="module_status[]" id="" class="form-control">
                                                    <option value="draft" {{ $module->module_status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="published" {{ $module->module_status == 'published' ? 'selected' : '' }}>Published</option>
                                                    <option value="unpublished" {{ $module->module_status == 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if ($module->resources != null || $module->prerequisites != null)
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_resources">Resources</label>
                                                <input type="text" name="module_resources[]" id="" class="form-control" value="{{ $module->resources ?? '' }}">
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="module_prerequisites">Prerequisites</label>
                                                <input type="text" name="module_prerequisites[]" id="" class="form-control" value="{{ $module->prerequisites ?? '' }}">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @endforeach
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

        <!-- jquery-validation -->
        <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $("input:not(.form-check-input, [name=_token]), textarea, select").prop("disabled", true);
                
                $('.description').each(function() {
                    $(this).summernote({
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
                    }).summernote('disable');
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
                const dropifyInput = document.getElementById('image');
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
