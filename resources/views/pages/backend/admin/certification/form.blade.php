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
                        <li class="breadcrumb-item active">{{ $title }}</li>
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
                    <form action="{{ route('admin.certification.store', $course) }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ $course ? old('title', $course->title) : old('title') }}" disabled>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter program price" value="{{ $course ? old('price', $course->price) : old('price') }}" disabled>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Discount (%)</label>
                                    <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter program discount (optional)" min="0" value="{{ $course ? old('discount', $course->discount) : old('discount') }}" max="100" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ $course ? old('start_date', $course->start_date) : old('start_date') }}" disabled>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ $course ? old('end_date', $course->end_date) : old('end_date') }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="course_format_id" class="form-label">Course Format</label>
                                <select class="form-control" aria-label="None" name="course_format_id" disabled>
                                    {{-- <option value="">None</option> --}}
                                    @foreach ($formats as $formats)
                                        <option value="{{ $formats->id }}"
                                            {{ ($course ? old('course_format_id', $course->course_format_id) : old('course_format_id')) == $formats->id ? 'selected' : '' }}>
                                            {{ $formats->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="course_categories_id" class="form-label">Course Program</label>
                                <select class="form-control" aria-label="None" name="course_categories_id" disabled>
                                    {{-- <option value="">None</option> --}}
                                    @foreach ($programs as $programs)
                                        <option value="{{ $programs->id }}"
                                            {{ ($course ? old('course_categories_id', $course->course_categories_id) : old('course_categories_id')) == $programs->id ? 'selected' : '' }}>
                                            {{ $programs->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" disabled>{{ $course ? old('description', $course->description) : old('description') }}</textarea>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="image" class="form-label">Program Image</label>
                                <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg" class="dropify"
                                    data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg"
                                    data-default-file="{{ asset('storage/courses/' . ($course ? old('image', $course->image) : old('image'))) }}"
                                    data-show-remove="false" />
                                <small>note: Ukuran gambar maksimal 2MB (.png, .jpg, .jpeg)</small>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th> <!-- Empty cell for top-left corner -->
                                    @foreach ($assignments as $assignment)
                                        <th>{{ $assignment->title }}</th>
                                    @endforeach
                                    <th>Nilai Akhir</th> <!-- Add Nilai Akhir column -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scoreMatrix as $studentName => $data)
                                    <tr>
                                        <td>{{ $studentName }}</td>
                                        @foreach ($assignments as $assignment)
                                            <td>
                                                @php
                                                    // Ambil nilai berdasarkan student_name dan assignment_title
                                                    $score = $data[$assignment->title] ?? 'N/A';
                                                @endphp
                                                {{ $score }}
                                            </td>
                                        @endforeach
                                        <td>{{ $data['final_score'] ?? 'N/A' }}</td> <!-- Display Nilai Akhir -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="row">
                            {{-- @dump($data) --}}
                            @foreach ($student_score as $item)
                                <div class="form-group col-md-6">
                                    <label for="score_{{ $item->user->id }}" class="form-label">{{ $item->user->name }}</label>
                                    <input type="number" name="score[{{ $item->user->id }}]" id="" class="form-control" value="{{ number_format($item->average_score, 1) }}">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

<!-- jquery-validation -->
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("input:not(.form-check-input, [name=_token]), textarea, select").prop("disabled", true);
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
