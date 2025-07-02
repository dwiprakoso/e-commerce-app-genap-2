@extends('member.layouts.app')
@section('content')
    <!-- Hero Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Video Wisata</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Nikmati pengalaman visual perjalanan wisata melalui
                        koleksi video terbaik kami</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Header End -->

    <!-- Video Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if ($videos->count() > 0)
                <div class="row g-4">
                    @foreach ($videos as $video)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                <!-- Video Thumbnail -->
                                <div class="position-relative">
                                    <div class="position-relative"
                                        style="height: 250px; background: linear-gradient(135deg, #dc3545, #6f42c1);">
                                        @if (str_contains($video->url, 'youtube.com') || str_contains($video->url, 'youtu.be'))
                                            @php
                                                $videoId = '';
                                                // YouTube watch URL
                                                if (str_contains($video->url, 'youtube.com/watch?v=')) {
                                                    parse_str(parse_url($video->url, PHP_URL_QUERY), $params);
                                                    $videoId = $params['v'] ?? '';
                                                }
                                                // YouTube short URL
                                                elseif (str_contains($video->url, 'youtu.be/')) {
                                                    $videoId = basename(parse_url($video->url, PHP_URL_PATH));
                                                }
                                                // YouTube embed URL
                                                elseif (str_contains($video->url, 'youtube.com/embed/')) {
                                                    $videoId = basename(parse_url($video->url, PHP_URL_PATH));
                                                }
                                            @endphp

                                            @if ($videoId)
                                                <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                                                    alt="{{ $video->title }}" class="card-img-top w-100 h-100"
                                                    style="object-fit: cover;"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <!-- Fallback jika thumbnail gagal load -->
                                                <div class="position-absolute top-50 start-50 translate-middle d-none">
                                                    <i class="fas fa-play-circle text-white fa-4x"
                                                        style="opacity: 0.5;"></i>
                                                </div>
                                            @else
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <i class="fas fa-play-circle text-white fa-4x"
                                                        style="opacity: 0.5;"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="position-absolute top-50 start-50 translate-middle">
                                                <i class="fas fa-play-circle text-white fa-4x" style="opacity: 0.5;"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Play Button Overlay -->
                                    {{-- <div class="position-absolute top-50 start-50 translate-middle">
                                        <div class="bg-dark bg-opacity-50 rounded-circle p-3 hover-bg-opacity-75">
                                            <i class="fas fa-play text-white fs-4 ms-1"></i>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3 text-truncate-2">{{ $video->title }}</h5>

                                    <!-- Meta Info -->
                                    <div class="d-flex align-items-center text-muted small mb-4">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($video->created_at)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('member.video.show', $video->id) }}" class="btn btn-danger mt-auto">
                                        <i class="fas fa-play me-2"></i>
                                        Tonton Video
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-video text-muted fa-5x"></i>
                    </div>
                    <h3 class="h3 text-muted mb-3">Belum Ada Video</h3>
                    <p class="text-muted mb-4">
                        @if (request('search'))
                            Tidak ditemukan video dengan kata kunci "{{ request('search') }}"
                        @else
                            Maaf, saat ini belum ada video yang tersedia.
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('member.video.index') }}" class="btn btn-danger rounded-pill py-3 px-5">
                            Lihat Semua Video
                        </a>
                    @else
                        <a href="{{ route('member.home') }}" class="btn btn-danger rounded-pill py-3 px-5">
                            Kembali ke Beranda
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <!-- Video Section End -->
@endsection

@push('styles')
    <style>
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
