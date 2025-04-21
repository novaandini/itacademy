@extends('layouts.backend.admin')

@section('konten')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">News & Event</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">News & Event</li>
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
                        <h3 class="card-title">Form News & Event</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ $data ? route('admin.news.update', $data->id) : route('admin.news.store') }}"
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

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-control" aria-label="None" name="category_id" required>
                                        <option value="">None</option>
                                        @foreach ($category as $category)
                                            <option value="{{ $category->id }}"
                                                {{ ($data ? old('category_id', $data->category_id) : old('category_id')) == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" name="date" id="date" class="form-control"
                                        value="{{ $data ? old('date', $data->date) : old('date') }}" required>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $data ? old('title', $data->title) : old('title') }}" required>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" required>{{ $data ? old('content', $data->content) : old('content') }}</textarea>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="file" class="form-label">Upload File</label>
                                    <input type="file" id="file" name="file" class="dropify"
                                        data-max-file-size="2M" required data-allowed-file-extensions="jpg png jpeg"
                                        data-default-file="{{ $data ? old('file', $data->image) : old('file') }}"
                                        data-show-remove="false" />
                                    <small>note: Ukuran gambar maksimal 2MB</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="caption" class="form-label">Caption Image</label>
                                    <input type="text" name="caption" id="caption" class="form-control"
                                        value="{{ $data ? old('caption', $data->caption) : old('caption') }}">
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" name="tags" id="tags" class="form-control"
                                        value="{{ $data ? old('tags', $data->tags) : old('tags') }}">
                                    <small>note: Pisahkan dengan titik koma, tanpa spasi. Contoh: blog;terbaru</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="keyword" class="form-label">Keywords</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                        value="{{ $data ? old('keyword', $data->keyword) : old('keyword') }}">
                                </div>
                                <div class="form-group mb-3 col-md-3">
                                    <label for="hit" class="form-label">Hit</label>
                                    <input type="number" name="hit" id="hit" class="form-control"
                                        value="{{ $data ? old('hit', $data->hit) : old('hit') }}">
                                </div>
                                <div class="form-group mb-3 col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" aria-label="Hit" required>
                                        <option value="hide"
                                            {{ ($data ? old('status', $data->status) : old('status')) == 'hide' ? 'selected' : '' }}>
                                            Hide</option>
                                        <option value="show"
                                            {{ ($data ? old('status', $data->status) : old('status')) == 'show' ? 'selected' : '' }}>
                                            Show</option>
                                    </select>
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
                $('#content').summernote({
                    tabsize: 2,
                    height: 100,
                    callbacks: {
                        onImageUpload: function(files) {
                            uploadImage(files[0]); // Pass the uploaded file to the upload function
                        }
                    }
                });

                function uploadImage(file) {
                    let formData = new FormData();
                    formData.append("image", file);
                    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

                    $.ajax({
                        url: '{{ route('admin.news.upload') }}', // Server endpoint to handle the upload
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) {
                                // Insert the uploaded image URL into the editor
                                $('#content').summernote('insertImage', response.url);
                            } else {
                                alert(response.message || 'Image upload failed!');
                            }
                        },
                        error: function() {
                            console.error(xhr.responseText);
                            alert('Image upload failed!');
                        }
                    });
                }

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
                const dropifyInput = document.getElementById('file');
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
