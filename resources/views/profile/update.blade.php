@extends('layouts.main')

@section('konten')
<br><br>
<!-- Edit Profile Section Start -->
<section class="section" id="edit-profile">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-8">
                <div class="left-images text-center">
                    <!-- Cek apakah pengguna telah mengunggah foto profil -->
                    @if(Auth::user()->image)
                        <!-- Jika ada foto profil -->
                        <img src="{{ asset('img/' . Auth::user()->image) }}" 
                             alt="Profile Picture" class="img-fluid rounded-circle mb-4" width="400" height="400">
                    @else
                        <!-- Jika tidak ada foto profil, tampilkan huruf depan dari email pengguna -->
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mx-auto mb-4"
                             style="width: 400px; height: 400px; font-size: 200px;">
                            {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Upload Foto Profil -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>

                       
<!-- Gender with Dropdown Icon -->
<div class="mb-3">
    <label for="gender" class="form-label">Gender</label>
    <div class="input-group">
        <select class="form-select" id="gender" name="gender" required>
            
            <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
            <span class="input-group-text">
                <i class="fa fa-chevron-down"></i>
            </span>
        </select>

    </div>
</div>


                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ Auth::user()->address }}">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="main-border-button">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Edit Profile Section End -->
@endsection
