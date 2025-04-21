@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <form action="{{ route('instructor.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <!-- Full Name -->
        <div class="row">
            <div class="form-group mb-3 col-6">
                <label for="parent_id" class="form-label">Parent Menu</label>
                <select class="form-select" id="inlineFormCustomSelectPref">
                    <option selected value="">none</option>
                    @foreach ($parent_id as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>               
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3 col-6">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </form>
</div>
@endsection