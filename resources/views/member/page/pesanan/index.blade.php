@extends('member.layouts.app')
@section('content')
    <!-- Hero Section Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Pesanan Saya</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Kelola dan pantau status pesanan paket wisata Anda
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Pesanan Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($pesanan->count() > 0)
                <div class="row g-4">
                    @foreach ($pesanan as $pesan)
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover">
                                <div class="row g-0">
                                    <!-- Image -->
                                    <div class="col-md-4">
                                        <div class="position-relative overflow-hidden h-100" style="min-height: 250px;">
                                            <img src="{{ asset('storage/' . $pesan->paketWisata->image_url) }}"
                                                alt="{{ $pesan->paketWisata->image_url }}" class="img-fluid w-100 h-100"
                                                style="object-fit: cover;">
                                            <!-- Status Badge -->
                                            <div class="position-absolute top-0 end-0 m-3">
                                                @if ($pesan->status == 'pending')
                                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow">
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    </span>
                                                @elseif ($pesan->status == 'dibatalkan')
                                                    <span class="badge bg-danger px-3 py-2 rounded-pill shadow">
                                                        <i class="fas fa-times me-1"></i>Dibatalkan
                                                    </span>
                                                @elseif ($pesan->status == 'selesai')
                                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow">
                                                        <i class="fas fa-check me-1"></i>Selesai
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="col-md-8">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h5 class="card-title mb-2">{{ $pesan->paketWisata->title }}</h5>
                                                    <p class="text-muted small mb-0">
                                                        ID Pesanan: #{{ str_pad($pesan->id, 6, '0', STR_PAD_LEFT) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Detail Pesanan -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                            {{ \Carbon\Carbon::parse($pesan->paketWisata->start_date)->format('d M Y') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($pesan->paketWisata->end_date)->format('d M Y') }}
                                                        </small>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="fas fa-users me-2 text-primary"></i>
                                                            {{ $pesan->jumlah_orang }} Orang
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="fas fa-clock me-2 text-primary"></i>
                                                            Dipesan: {{ $pesan->created_at->format('d M Y H:i') }}
                                                        </small>
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong class="text-success d-flex align-items-center">
                                                            <i class="fas fa-money-bill-wave me-2"></i>
                                                            Rp {{ number_format($pesan->total_harga, 0, ',', '.') }}
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bukti Bayar -->
                                            @if ($pesan->bukti_bayar)
                                                <div class="mb-3">
                                                    <small class="text-muted mb-2 d-block">
                                                        <i class="fas fa-receipt me-1"></i>Bukti Bayar:
                                                    </small>
                                                    <a href="{{ asset('storage/' . $pesan->bukti_bayar) }}" target="_blank"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i>
                                                        Lihat Bukti Bayar
                                                    </a>
                                                </div>
                                            @endif

                                            <!-- Actions -->
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('member.paket-wisata.show', $pesan->paketWisata->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Detail Paket
                                                </a>
                                            </div>
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
                        <i class="fas fa-shopping-cart text-muted fa-5x mb-3"></i>
                    </div>
                    <h3 class="text-muted mb-4">Belum Ada Pesanan</h3>
                    <p class="text-muted mb-4">Anda belum memiliki pesanan paket wisata.</p>
                    <a href="{{ route('member.paket-wisata.index') }}" class="btn btn-primary rounded-pill py-3 px-5">
                        <i class="fas fa-search me-2"></i>
                        Jelajahi Paket Wisata
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- Pesanan Section End -->
@endsection

@push('styles')
    <style>
        .hero-header {
            background: linear-gradient(rgba(19, 53, 123, 0.8), rgba(19, 53, 123, 0.8)), url('assets/img/carousel-2.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush
