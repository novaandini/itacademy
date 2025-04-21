@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <!-- Certificate Background -->
    <div class="p-5 shadow-lg rounded-4 position-relative overflow-hidden" 
         style="background: url('{{ asset('assets/img/SERTIF.png') }}') no-repeat center center / contain; 
                border-radius: 10px; padding: 60px; background-size: 100% 100%;">
<br><br><br><br><br><br>
        <!-- Certificate Header -->
        <h2 class="text-uppercase fw-bold text-center mb-0" 
            style="font-size: 2.8rem; color: #2c3e50; letter-spacing: 2px; text-shadow: 2px 2px #ddd;">
            Certificate of Completion
        </h2>
        <p class="text-muted fst-italic text-center mb-3" 
           style="font-size: 1.3rem; color: #555; margin-top: 0.5rem;">
            Presented to
        </p>

        <!-- Recipient Name -->
        <h1 class="display-4 fw-bold text-center text-primary mb-5" 
            style="text-transform: uppercase; color: #1a73e8; font-size: 3rem;">
            <span style="border-bottom: 2px solid #2c3e50; padding-bottom: 5px; display: inline-block; width: 70%;">
                {{ $certification->user->name ?? 'Unknown Recipient' }}
            </span>
        </h1>

        <!-- Achievement Section -->
        <p class="mt-4 text-muted text-center" style="font-size: 1.2rem; color: #666;">
            In recognition of successfully completing the program:
        </p>
        <h3 class="fw-bold mb-4 text-center text-secondary" style="font-size: 2rem; color: #444;">
            {{ $certification->course->title ?? 'No Course' }}
        </h3>

        <!-- Description -->
        <p class="text-muted mb-5 text-center" style="font-size: 1.1rem; color: #666; line-height: 1.5;">
            {{ $certification->description }}
        </p>
        
        <!-- Certificate Number -->
        <p class="text-muted text-center mb-5" style="font-size: 1rem; color: #777;">
            {{ $certification->certificate_number ?? 'Not Available' }}
        </p>

        <!-- Date and Signature -->
        <div class="row mt-5 justify-content-center">
            <div class="col-md-4 text-center">
                <p class="text-muted mb-1" style="font-size: 1rem; color: #777;"><strong>Bali, 
                    {{ \Carbon\Carbon::parse($certification->date)->format('j F, Y') ?? 'No Date' }}</p></strong>
                <img src="{{ asset('assets/img/TTD.png') }}" alt="Signature" 
                     style="width: 150px; height: auto; solid #ccc;">
            </div>
        </div>

        <!-- Download Button -->
        <div class="mt-5 text-center">
            <a href="{{ route('certificate.download', $certification->id) }}" class="btn btn-outline-primary btn-lg rounded-pill px-5 py-2 shadow-sm">
                <i class="fas fa-download me-2"></i> Download Certificate
            </a>
        </div>
    </div>
</div>
@endsection
