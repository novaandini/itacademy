@extends('layouts.main')

@section('konten')
<br><br>
<!-- Profile Section Start -->
<section class="section" id="profile">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="profile-image-container">
                    <!-- Display profile picture or initial based on availability -->
                    @if(isset($instructor) && $instructor->image)
                        <!-- Instructor profile image -->
                        <img src="{{ asset($instructor->image) }}" 
                             alt="Profile Picture" class="profile-image rounded-circle shadow-lg mb-4" width="400" height="400">
                    @elseif($user->image)
                        <!-- User profile image -->
                        <img src="{{ asset('assets/img/users/' . $user->image) }}" 
                             alt="Profile Picture" class="profile-image rounded-circle shadow-lg mb-4" width="400" height="400">
                    @else
                        <!-- Display initial placeholder if no profile picture -->
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mx-auto mb-4 shadow-lg"
                             style="width: 400px; height: 400px; font-size: 200px;">
                            {{ strtoupper(substr($user->email, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content text-center text-lg-start">
                    <!-- Full Name -->
                    <h2 class="mb-3 text-uppercase fw-bold">{{ isset($instructor) ? $instructor->name : $user->name }}</h2>

                    <!-- Email -->
                    <p class="h5 text-primary mb-4">
                        <i class="fas fa-envelope me-2 text-primary"></i>{{ $user->email }}
                    </p>

                    <!-- Additional Information -->
                    <div class="description mt-3">
                        <p><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Address: </strong>{{ isset($instructor) ? $instructor->address : $user->address ?? 'No address provided' }}</p>
                        <p><i class="fas fa-phone me-2 text-primary"></i><strong>Phone Number: </strong>{{ isset($instructor) ? $instructor->phone : $user->phone ?? 'No phone number provided' }}</p>
                        <p><i class="fas fa-birthday-cake me-2 text-primary"></i><strong>Date of Birth: </strong>{{ isset($instructor) ? \Carbon\Carbon::parse($instructor->date_of_birth)->format('F j, Y') : ($user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F j, Y') : 'Not provided') }}</p>
                        
                        <!-- Instructor-specific field for skills -->
                        @if(isset($instructor) && $instructor->skills)
                            <p><i class="fas fa-chalkboard-teacher me-2 text-primary"></i><strong>Skills: </strong>{{ $instructor->skills }}</p>
                        @endif
                    </div>
                    @auth

                    @if (Auth::user()->role === 'student')
                    <!-- Edit Profile Button -->
                    <div class="main-border-button mt-4">
                        <a href="{{ url('/update') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i class="fa fa-edit me-2"></i> Edit Profile
                        </a>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Section End -->

<!-- Custom CSS for Profile Page -->
<style>
    .profile-image-container {
        display: flex;
        justify-content: center;
    }
    .profile-image {
        width: 400px;
        height: 400px;
        border: 8px solid #7e3a3a; /* Frame styling */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow */
        object-fit: cover; /* Ensures image covers frame proportionately */
    }
</style>
@endsection
