@extends('member.layouts.app')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary py-5 page-header">
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-3 text-white animated slideInDown mb-4">{{ $paket->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb text-uppercase mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.home') }}" class="text-white">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.paket-wisata.index') }}" class="text-white">Paket Wisata</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detail Paket</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Package Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Package Header -->
                    <div class="mb-4">
                        <!-- Meta Information -->
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <div class="d-flex align-items-center me-4">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($paket->start_date)->format('d F Y') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($paket->start_date)->diffInDays(\Carbon\Carbon::parse($paket->end_date)) + 1 }}
                                    Hari</span>
                            </div>
                        </div>
                    </div>

                    <!-- Package Details -->
                    <div class="row mb-5">
                        <!-- Package Image -->
                        <div class="col-lg-6 mb-4">
                            <div class="bg-gradient-primary d-flex align-items-center justify-content-center rounded overflow-hidden shadow position-relative"
                                style="height: 400px;">
                                @if ($paket->image_url)
                                    <img src="{{ asset('storage/' . $paket->image_url) }}" alt="{{ $paket->title }}"
                                        class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="fas fa-image text-white fa-4x opacity-50"></i>
                                @endif

                                <!-- Status Badge -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    @if ($paket->status == 'publish')
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="badge bg-warning fs-6 px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Package Information -->
                        <div class="col-lg-6">
                            <!-- Price -->
                            <div class="mb-4">
                                <h2 class="display-5 text-primary fw-bold mb-2">
                                    Rp {{ number_format($paket->price, 0, ',', '.') }}
                                </h2>
                                <span class="text-muted fs-5">per orang</span>
                            </div>

                            <!-- Info Cards -->
                            <div class="row g-3 mb-4">
                                <!-- Tanggal Keberangkatan -->
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                                            <span class="fw-semibold">Keberangkatan</span>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($paket->start_date)->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <!-- Tanggal Kembali -->
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-check text-primary me-2"></i>
                                            <span class="fw-semibold">Kembali</span>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($paket->end_date)->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <!-- Durasi -->
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <span class="fw-semibold">Durasi</span>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($paket->start_date)->diffInDays(\Carbon\Carbon::parse($paket->end_date)) + 1 }}
                                            Hari</p>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-info-circle text-primary me-2"></i>
                                            <span class="fw-semibold">Status</span>
                                        </div>
                                        <p class="mb-0 text-muted text-capitalize">{{ $paket->status }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="d-grid">
                                <a href="{{ route('member.paket-wisata.pesan', $paket->id) }}"
                                    class="btn btn-success btn-lg">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-light p-4 rounded mb-5">
                        <h3 class="fw-bold text-dark mb-3">Deskripsi Paket</h3>
                        <p class="text-muted mb-0 lh-lg">{{ $paket->description }}</p>
                    </div>

                    <!-- Back Button Section -->
                    <div class="border-top pt-4 mt-5">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h5 class="fw-bold text-dark mb-3">Bagikan Paket</h5>
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
                                <a href="{{ route('member.paket-wisata.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Paket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Packages -->
    @if ($paketLainnya->count() > 0)
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Paket Lainnya</h6>
                    <h1 class="mb-5">Paket Wisata Menarik Lainnya</h1>
                </div>

                <div class="row g-4">
                    @foreach ($paketLainnya as $paketLain)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                <!-- Package Image -->
                                <div class="position-relative">
                                    <div class="bg-gradient-primary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        @if ($paketLain->image_url)
                                            <img src="{{ asset('storage/' . $paketLain->image_url) }}"
                                                alt="{{ $paketLain->title }}" class="card-img-top"
                                                style="height: 250px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-image text-white fa-4x opacity-50"></i>
                                        @endif
                                    </div>

                                    <!-- Price Badge -->
                                    <div class="position-absolute bottom-0 start-0 m-3">
                                        <span class="badge bg-white text-primary fs-6 px-3 py-2 shadow">
                                            Rp {{ number_format($paketLain->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3 text-truncate-2">{{ $paketLain->title }}</h5>
                                    <p class="card-text text-muted mb-3 text-truncate-2">
                                        {{ Str::limit($paketLain->description, 100) }}</p>

                                    <!-- Date Info -->
                                    <div class="d-flex align-items-center text-muted mb-4">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        <small>{{ \Carbon\Carbon::parse($paketLain->start_date)->format('d M Y') }}</small>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('member.paket-wisata.show', $paketLain->id) }}"
                                        class="btn btn-primary mt-auto">
                                        <i class="fas fa-eye me-2"></i>
                                        Lihat Detail
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
