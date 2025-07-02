@extends('member.layouts.app')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary py-5 page-header">
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-3 text-white animated slideInDown mb-4">{{ $berita->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb text-uppercase mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.home') }}" class="text-white">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.berita.index') }}" class="text-white">Berita</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detail Berita</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Article Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Article Header -->
                    <div class="mb-4">
                        <!-- Meta Information -->
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <div class="d-flex align-items-center me-4">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($berita->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-5">
                        <div class="bg-gradient-primary d-flex align-items-center justify-content-center rounded overflow-hidden shadow position-relative"
                            style="height: 400px;">
                            @if ($berita->image_url)
                                <img src="{{ asset('storage/' . $berita->image_url) }}" alt="{{ $berita->title }}"
                                    class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <i class="fas fa-newspaper text-white fa-4x opacity-50"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="article-content mb-5">
                        <div class="text-muted fs-5 lh-lg">
                            {!! nl2br(e($berita->content)) !!}
                        </div>
                    </div>

                    <!-- Share Section -->
                    <div class="border-top pt-4 mt-5">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h5 class="fw-bold text-dark mb-3">Bagikan Artikel</h5>
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
                                <a href="{{ route('member.berita.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    @if ($beritaLainnya->count() > 0)
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Berita Lainnya</h6>
                    <h1 class="mb-5">Artikel Menarik Lainnya</h1>
                </div>

                <div class="row g-4">
                    @foreach ($beritaLainnya as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                <!-- Article Image -->
                                <div class="position-relative">
                                    <div class="bg-gradient-primary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        @if ($item->image_url)
                                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}"
                                                class="card-img-top" style="height: 250px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-newspaper text-white fa-4x opacity-50"></i>
                                        @endif
                                    </div>

                                    <!-- Date Badge -->
                                    <div class="position-absolute bottom-0 start-0 m-3">
                                        <span class="badge bg-white text-primary fs-6 px-3 py-2 shadow">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3 text-truncate-2">{{ $item->title }}</h5>
                                    <p class="card-text text-muted mb-3 text-truncate-2">
                                        {{ Str::limit(strip_tags($item->content), 100) }}</p>

                                    <!-- Date Info -->
                                    <div class="d-flex align-items-center text-muted mb-4">
                                        <i class="fas fa-clock me-2 text-primary"></i>
                                        <small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('member.berita.show', $item->id) }}" class="btn btn-primary mt-auto">
                                        <i class="fas fa-eye me-2"></i>
                                        Baca Artikel
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

        .article-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
    </style>
@endpush
