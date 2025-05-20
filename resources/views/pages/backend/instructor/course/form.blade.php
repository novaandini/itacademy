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
                        <form action="{{ $data ? route('instructor.course.update', $data->id) : route('instructor.course.store') }}"
                            method="POST" enctype="multipart/form-data" class="custom-validation">
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
                                        <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter program discount (optional)" min="0" max="100" value="{{ $data ? old('discount', $data->discount) : old('discount') }}">
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
                                    <label for="formats_id" class="form-label">Course Format</label>
                                    <select class="form-control" aria-label="None" name="formats_id" required>
                                        <option value="">None</option>
                                        @foreach ($formats as $formats)
                                            <option value="{{ $formats->id }}"
                                                {{ ($data ? old('formats_id', $data->formats_id) : old('formats_id')) == $formats->id ? 'selected' : '' }}>
                                                {{ $formats->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="programs_id" class="form-label">Course Category</label>
                                    <select class="form-control" aria-label="None" name="programs_id" required>
                                        <option value="">None</option>
                                        @foreach ($programs as $programs)
                                            <option value="{{ $programs->id }}"
                                                {{ ($data ? old('programs_id', $data->programs_id) : old('programs_id')) == $programs->id ? 'selected' : '' }}>
                                                {{ $programs->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Number of Students -->
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Number of Students</label>
                                <input type="number" class="form-control" id="capacity" value="0" name="capacity" placeholder="Enter number of students" value="{{ $data ? old('capacity', $data->capacity) : old('capacity') }}" required>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control" required>{{ $data ? old('description', $data->description) : old('description') }}</textarea>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="image" class="form-label">Program Image</label>
                                    <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg" class="dropify"
                                        data-max-file-size="2M" required data-allowed-file-extensions="jpg png jpeg"
                                        data-default-file="{{ $data ? old('image', $data->image) : old('image') }}"
                                        data-show-remove="false" />
                                    <small>note: Ukuran gambar maksimal 2MB (.png, .jpg, .jpeg)</small>
                                </div>
                            </div>

                            <div class="" id="moduleContainer">
                                <hr>
                                <div class="h3 text-center">Course Module</div>
                                <div class="row">
                                    <div class="form-group mb-3 col-md-12">
                                        <label for="module_titles">Module Title</label>
                                        <input type="text" name="module_titles[]" id="" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group mb-3 col-md-12">
                                        <label for="module_descriptions">Module Description</label>
                                        <textarea name="module_descriptions[]" id="moduleDescription" cols="30" rows="10" class="form-control" required>{{ $data ? old('description', $data->description) : old('description') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group mb-3 col-md-12">
                                        <label for="module_objectives">Learning Objectives</label>
                                        <input type="text" name="module_objectives[]" id="" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_contents">Content/Material</label>
                                        <input type="text" name="module_contents[]" id="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_durations">Duration (hours)</label>
                                        <input type="number" name="module_durations[]" value="0" min="1" max="100" id="" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_activities">Activities</label>
                                        <input type="text" name="module_activities[]" id="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_assesssment_types">Assessment Type</label>
                                        <input type="text" name="module_assesssment_types[]" id="" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_passing_grades">Passing Grade (%)</label>
                                        <input type="number" name="module_passing_grades[]" min="1" max="100" id="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_status">Status</label>
                                        <select name="module_status[]" id="" class="form-control">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="unpublished">Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_resources">Resources</label>
                                        <input type="text" name="module_resources[]" id="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="module_prerequisites">Prerequisites</label>
                                        <input type="text" name="module_prerequisites[]" id="" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="">
                                <button type="button" class="btn btn-danger" id="addModule">Add Module</button>
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
                $('#moduleDescription').addClass('module-summernote').summernote({
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
                const dropifyInput = document.getElementById('image');
                if (dropifyInput.dataset.defaultFile) {
                    dropifyInput.removeAttribute('required');
                }

                $('#addModule').on('click', function() {
                    console.log('Tombol diklik');
                    const moduleHTML = `
                        <hr>
                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label>Module Title</label>
                                <input type="text" name="module_titles[]" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label>Module Description</label>
                                <textarea name="module_descriptions[]" class="form-control module-summernote" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label>Learning Objectives</label>
                                <input type="text" name="module_objectives[]" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label>Content/Material</label>
                                <input type="text" name="module_contents[]" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label>Duration (hours)</label>
                                <input type="number" name="module_durations[]" value="0" min="1" max="100" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label>Activities</label>
                                <input type="text" name="module_activities[]" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label>Assessment Type</label>
                                <input type="text" name="module_assesssment_types[]" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label>Passing Grade (%)</label>
                                <input type="number" name="module_passing_grades[]" min="1" max="100" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label>Status</label>
                                <select name="module_status[]" class="form-control">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="unpublished">Unpublished</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label>Resources</label>
                                <input type="text" name="module_resources[]" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label>Prerequisites</label>
                                <input type="text" name="module_prerequisites[]" class="form-control">
                            </div>
                        </div>
                    `;

                    $('#moduleContainer').append(moduleHTML);

                    // Re-init Summernote untuk textarea baru
                    $('.module-summernote').last().summernote({
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
                });
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
