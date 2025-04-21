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
    }

    .image-container img {
        width: 100%; /* Gambar memenuhi lebar container */
        height: 100%;
        object-fit: cover; /* Gambar tetap terpotong sesuai rasio */
    }
    
    .card-title, .card-text {
        height: 72px;
        overflow: hidden;
        display: -webkit-box; /* Gunakan layout fleksibel */
        -webkit-line-clamp: 3; /* Batasi hingga 3 baris */
        -webkit-box-orient: vertical; /* Orientasi vertikal */
        text-overflow: ellipsis; /* Tambahkan ellipsis (...) */
    }
</style>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">News</h6>
            <h1 class="mb-3">News & Event</h1>
        </div>
        <div class="row">
            @foreach ($data as $item)
            <div class="col-md-4 mb-3">
                <a href="{{ route('news-event.show', $item->slug) }}">
                    <div class="card">
                        <div class="image-container">
                            <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->caption }}">
                        </div>
                        <div class="card-body text-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{!! strip_tags($item->content) !!}</p>
                            <div class="d-flex">
                                <small>{{ Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection