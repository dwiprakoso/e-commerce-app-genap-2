@extends('member.layouts.app')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary py-5 page-header">
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-3 text-white animated slideInDown mb-4">{{ $video->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb text-uppercase mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.home') }}" class="text-white">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.video.index') }}" class="text-white">Video</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detail Video</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Video Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Video Header -->
                    <div class="mb-4">
                        <!-- Meta Information -->
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <div class="d-flex align-items-center me-4">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($video->created_at)->format('d F Y') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Video Player -->
                    <div class="mb-5">
                        <div class="ratio ratio-16x9 bg-dark rounded overflow-hidden shadow">
                            @if (str_contains($video->url, 'youtube.com') || str_contains($video->url, 'youtu.be'))
                                @php
                                    $embedUrl = '';
                                    if (str_contains($video->url, 'youtube.com/watch?v=')) {
                                        $videoId = substr($video->url, strpos($video->url, 'v=') + 2);
                                        $videoId = strpos($videoId, '&')
                                            ? substr($videoId, 0, strpos($videoId, '&'))
                                            : $videoId;
                                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                    } elseif (str_contains($video->url, 'youtu.be/')) {
                                        $videoId = substr($video->url, strpos($video->url, 'youtu.be/') + 9);
                                        $videoId = strpos($videoId, '?')
                                            ? substr($videoId, 0, strpos($videoId, '?'))
                                            : $videoId;
                                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                    } elseif (str_contains($video->url, 'youtube.com/embed/')) {
                                        $embedUrl = $video->url;
                                    }
                                @endphp
                                @if ($embedUrl)
                                    <iframe src="{{ $embedUrl }}" class="rounded" frameborder="0" allowfullscreen>
                                    </iframe>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <div class="text-center text-white">
                                            <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
                                            <h5 class="mb-3">Video tidak dapat ditampilkan</h5>
                                            <a href="{{ $video->url }}" target="_blank" class="btn btn-outline-light">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                Buka di tab baru
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <!-- For other video formats -->
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-center text-white">
                                        <i class="fas fa-play-circle fa-5x mb-4"></i>
                                        <h5 class="mb-4">Klik untuk menonton video</h5>
                                        <a href="{{ $video->url }}" target="_blank" class="btn btn-primary btn-lg">
                                            <i class="fas fa-play me-2"></i>
                                            Tonton Video
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Share Section -->
                    <div class="border-top pt-4 mt-5">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h5 class="fw-bold text-dark mb-3">Bagikan Video</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary">
                                        <i class="fab fa-facebook-f me-2"></i>
                                        Facebook
                                    </button>
                                    <button class="btn btn-info text-white">
                                        <i class="fab fa-twitter me-2"></i>
                                        Twitter
                                    </button>
                                    <button class="btn btn-success">
                                        <i class="fab fa-whatsapp me-2"></i>
                                        WhatsApp
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                <a href="{{ route('member.video.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Video
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Videos -->
    @if ($videoLainnya->count() > 0)
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Video Lainnya</h6>
                    <h1 class="mb-5">Video Menarik Lainnya</h1>
                </div>

                <div class="row g-4">
                    @foreach ($videoLainnya as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                <!-- Video Thumbnail -->
                                <div class="position-relative">
                                    <div class="bg-gradient-primary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        @if (str_contains($item->url, 'youtube.com') || str_contains($item->url, 'youtu.be'))
                                            @php
                                                $videoId = '';
                                                if (str_contains($item->url, 'youtube.com/watch?v=')) {
                                                    $videoId = substr($item->url, strpos($item->url, 'v=') + 2);
                                                    $videoId = strpos($videoId, '&')
                                                        ? substr($videoId, 0, strpos($videoId, '&'))
                                                        : $videoId;
                                                } elseif (str_contains($item->url, 'youtu.be/')) {
                                                    $videoId = substr($item->url, strpos($item->url, 'youtu.be/') + 9);
                                                    $videoId = strpos($videoId, '?')
                                                        ? substr($videoId, 0, strpos($videoId, '?'))
                                                        : $videoId;
                                                }
                                            @endphp
                                            @if ($videoId)
                                                <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg"
                                                    alt="{{ $item->title }}" class="card-img-top"
                                                    style="height: 250px; object-fit: cover;">
                                            @else
                                                <i class="fas fa-play-circle text-white fa-4x opacity-50"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-play-circle text-white fa-4x opacity-50"></i>
                                        @endif
                                    </div>

                                    <!-- Play Button Overlay -->
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <div class="bg-dark bg-opacity-75 rounded-circle p-3 hover-overlay">
                                            <i class="fas fa-play text-white fa-2x ms-1"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3 text-truncate-2">{{ $item->title }}</h5>

                                    <!-- Date Info -->
                                    <div class="d-flex align-items-center text-muted mb-4">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        <small>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('member.video.show', $item->id) }}" class="btn btn-primary mt-auto">
                                        <i class="fas fa-play me-2"></i>
                                        Tonton Video
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .hover-overlay {
            transition: all 0.3s ease;
        }

        .hover-overlay:hover {
            background-color: rgba(0, 0, 0, 0.9) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endpush
