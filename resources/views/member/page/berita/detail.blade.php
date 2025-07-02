@extends('member.layouts.app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid bg-primary py-5 mb-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb breadcrumb-dark mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.home') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Beranda
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.berita.index') }}"
                                    class="text-white text-decoration-none">Berita</a>
                            </li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">
                                {{ Str::limit($berita->title, 50) }}</li>
                        </ol>
                    </nav>

                    <!-- Page Title -->
                    <div class="text-white">
                        <h1 class="display-4 text-white mb-0 animated slideInDown">Detail Berita</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Article Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Article Header -->
                    <div class="mb-5">
                        <h1 class="display-5 fw-bold text-dark mb-4">{{ $berita->title }}</h1>

                        <!-- Meta Information -->
                        <div class="d-flex flex-wrap align-items-center text-muted mb-4">
                            <div class="me-4 mb-2">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <span>{{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}</span>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span>{{ \Carbon\Carbon::parse($berita->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-5">
                        <div class="rounded overflow-hidden shadow-lg">
                            @if ($berita->image_url)
                                <img src="{{ asset('storage/' . $berita->image_url) }}" alt="{{ $berita->title }}"
                                    class="img-fluid w-100" style="height: 400px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 400px;">
                                    <i class="fas fa-newspaper text-primary fa-5x opacity-50"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="article-content mb-5">
                        <div class="text-muted fs-5 lh-lg">
                            {!! nl2br(e($berita->content)) !!}
                        </div>
                    </div>

                    <!-- Back Button Section -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('member.berita.index') }}"
                                class="btn btn-outline-primary rounded-pill px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Article Content End -->

    <!-- Related Articles Start -->
    @if ($beritaLainnya->count() > 0)
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Berita Lainnya</h6>
                    <h2 class="mb-4">Artikel Menarik Lainnya</h2>
                    <p class="text-muted">Artikel menarik lainnya yang mungkin Anda suka</p>
                </div>

                <div class="row g-4">
                    @foreach ($beritaLainnya as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                @if ($item->image_url)
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top"
                                            alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                        <!-- Date Badge -->
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow">
                                                <i class="fa fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center position-relative"
                                        style="height: 200px;">
                                        <i class="fas fa-newspaper text-primary fa-3x opacity-50"></i>
                                        <!-- Date Badge -->
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow">
                                                <i class="fa fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3 line-clamp-2">{{ $item->title }}</h5>
                                    <p class="card-text flex-grow-1 text-muted line-clamp-2">
                                        {{ Str::limit(strip_tags($item->content), 100) }}
                                    </p>

                                    <!-- Meta Info -->
                                    <div class="d-flex align-items-center text-muted mb-3">
                                        <small><i class="fas fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('member.berita.show', $item->id) }}" class="btn btn-primary mt-auto">
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
    <!-- Related Articles End -->
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .breadcrumb-dark .breadcrumb-item+.breadcrumb-item::before {
            content: var(--bs-breadcrumb-divider, ">") !important;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Fix untuk navbar yang tersembunyi */
        body {
            padding-top: 100px;
            /* Beri ruang untuk navbar */
        }

        /* Fix sidebar/navbar supaya fixed di atas dengan shadow */
        .container-fluid.position-relative.p-0:first-child,
        nav.navbar:first-child {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1050 !important;
            background-color: #fff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        /* Pastikan breadcrumb tidak tertutup navbar */
        .container-fluid.bg-primary {
            position: relative;
            z-index: 1;
        }

        /* Styling untuk navbar agar terlihat jelas */
        .navbar-brand h1 {
            color: #13357B !important;
        }

        .navbar-nav .nav-link {
            color: #333 !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #13357B !important;
        }
    </style>
@endpush
