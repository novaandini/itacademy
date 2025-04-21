@extends('layouts.main')

@section('konten')

@php
    use Carbon\Carbon;
@endphp

<style>
    .image-container {
        width: 100%; /* Lebar fleksibel */
        aspect-ratio: 16 / 9; /* Rasio 3:4 */
        overflow: hidden; /* Agar gambar tidak keluar dari area */
        margin: auto;
    }

    .image-container img {
        width: 100%; /* Gambar memenuhi lebar container */
        height: 100%;
        object-fit: cover; /* Gambar tetap terpotong sesuai rasio */
    }
</style>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">News $ Event</h6>
            <h1 class="mb-3">{{ $data->title }}</h1>
        </div>
        <div class="w-75 m-auto">
            <div class="image-container my-2">
                <img src="{{ $data->image }}" alt="{{ $data->caption }}">
            </div>
            <div class="d-flex justify-content-between col-lg-6 flex-wrap">
                <p><i class="fa fa-calendar-day"></i> {{ Carbon::parse($data->date)->translatedFormat('l, d F Y') }}</p>
                <p><i class="fa fa-hashtag"></i> {{ $data->category->title }}</p>
                <p><i class="fa fa-users"></i> {{ $data->hit }}</p>
            </div>
            {!! $data->content !!}
        </div>
    </div>
</div>
@endsection