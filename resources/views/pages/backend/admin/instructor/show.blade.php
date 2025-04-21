@extends('layouts.backend.admin')
@section('konten')

<div class="content-wrapper">
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
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form News & Event</h3>
                </div>

                @if (session('error'))
                    {{ session('error') }}
                @endif
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.instructor.validation', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    
                        <!-- Full Name -->
                        <div class="row">
                            <div class="form-group mb-3 col-12">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $data->name) }}" disabled>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Address -->
                            <div class="form-group mb-3 col-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $data->address) }}" readonly>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Date of Birth -->
                            <div class="form-group mb-3 col-6">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $data->date_of_birth) }}" readonly>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="form-group mb-3 col-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $data->phone) }}" readonly>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <!-- Email -->
                            <div class="form-group mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data->email) }}" readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Phone Number -->
                    
                        <!-- Skills -->
                        <div class="form-group mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <input type="text" name="skills" id="skills" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills', $data->instructor->skills) }}" placeholder="e.g., Web Development, Data Science" readonly>
                            @error('skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="A brief summary about yourself" rows="3">{{ old('description', $data->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Profile Image -->
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" id="file" name="file" class="dropify"
                                data-max-file-size="2M" disabled data-allowed-file-extensions="jpg png jpeg"
                                data-default-file="{{ asset('storage/instructors/' . ($data ? old('file', $data->image) : old('file'))) }}"
                                data-show-remove="false" />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($data->image != null)
                                <a href="{{ asset('storage/instructors/' . $data->image) }}" target="_blank"><small>Download image</small></a>
                            @endif
                        </div>
                    
                        <!-- CV Upload -->
                        <div class="form-group mb-3">
                            <label for="cv" class="form-label">Upload CV</label>
                            <input type="file" id="file" name="file" class="dropify"
                                data-max-file-size="2M" disabled data-allowed-file-extensions="jpg png jpeg"
                                data-default-file="{{ asset('storage/cvs/' . ($data ? old('file', $data->instructor->cv) : old('file'))) }}"
                                data-show-remove="false" />
                            @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <a href="{{ asset('storage/cvs/' . $data->instructor->cv) }}" target="_blank"><small>Download CV</small></a>
                        </div>
                        
                        <!-- Approve and Reject buttons -->
                        {{-- <form action="{{ route('admin.instructor.approve', $instructor->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm me-2">
                                <i class="bi bi-check-circle"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.instructor.reject', $instructor->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                        </form> --}}
                        
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Action</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="validation" id="approveInstructor" value="approve" checked>
                                <label class="form-check-label" for="approveInstructor">
                                Approve
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="validation" id="rejectInstructor" value="reject">
                                <label class="form-check-label" for="rejectInstructor">
                                Reject
                                </label>
                            </div>
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