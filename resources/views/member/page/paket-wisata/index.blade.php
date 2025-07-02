@extends('member.layouts.app')
@section('content')
    <!-- Hero Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Paket Wisata Terbaik</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Pilih paket wisata impian Anda dan nikmati
                        pengalaman tak terlupakan di Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Header End -->

    <!-- Paket Wisata Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if ($paketWisata->count() > 0)
                <div class="row g-4">
                    @foreach ($paketWisata as $paket)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                <!-- Image -->
                                <div class="position-relative"
                                    style="height: 250px; background: linear-gradient(135deg, #007bff, #6f42c1);">
                                    @if ($paket->image_url)
                                        <img src="{{ asset('storage/' . $paket->image_url) }}" alt="{{ $paket->title }}"
                                            class="card-img-top w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <i class="fas fa-image text-white fa-4x" style="opacity: 0.5;"></i>
                                        </div>
                                    @endif

                                    <!-- Price Badge -->
                                    <div class="position-absolute bottom-0 start-0 m-3">
                                        <span class="badge bg-white text-primary fs-6 fw-bold py-2 px-3 shadow">
                                            Rp {{ number_format($paket->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3">{{ $paket->title }}</h5>
                                    <p class="card-text flex-grow-1 text-truncate-3">{{ $paket->description }}</p>

                                    <!-- Date Info -->
                                    <div class="d-flex align-items-center text-muted small mb-3">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($paket->start_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($paket->end_date)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Duration -->
                                    <div class="d-flex align-items-center text-muted small mb-4">
                                        <i class="fas fa-clock me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($paket->start_date)->diffInDays(\Carbon\Carbon::parse($paket->end_date)) + 1 }}
                                            Hari</span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row g-2 mt-auto">
                                        <div class="col-6">
                                            <a href="{{ route('member.paket-wisata.show', $paket->id) }}"
                                                class="btn btn-primary w-100">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Detail
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('member.paket-wisata.pesan', $paket->id) }}"
                                                class="btn btn-success w-100">
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                Pesan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-map-marked-alt text-muted fa-5x"></i>
                    </div>
                    <h3 class="h3 text-muted mb-3">Belum Ada Paket Wisata</h3>
                    <p class="text-muted mb-4">Maaf, saat ini belum ada paket wisata yang tersedia.</p>
                    <a href="{{ route('member.home') }}" class="btn btn-primary rounded-pill py-3 px-5">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- Paket Wisata Section End -->
@endsection

@push('styles')
    <style>
        .text-truncate-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
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
