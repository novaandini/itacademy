@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Assignment</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Assignment</li>
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
                    <h2 class="card-title">Submit Assignment: {{ $data->title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.assignment.store', [$course, $data->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="form-group mb-3 col-md-12">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $data ? old('content', $data->content) : old('content') }}</textarea>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" id="file" name="file" class="dropify"
                                data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg"
                                data-default-file="{{ $data ? old('file', $data->image) : old('file') }}"
                                data-show-remove="false" />
                            <small>note: Ukuran gambar maksimal 2MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
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
            // const dropifyInput = document.getElementById('file');
            // if (dropifyInput.dataset.defaultFile) {
            //     dropifyInput.removeAttribute('required');
            // }
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
        });
    </script>
@endpush