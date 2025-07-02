@extends('member.layouts.app')
@section('content')
    <!-- Hero Section Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Berita Terkini</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Ikuti berita dan update terbaru seputar dunia
                        pariwisata Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Berita Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($berita->count() > 0)
                <div class="row g-4">
                    @foreach ($berita as $item)
                        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover mb-4">
                                <div class="row g-0">
                                    <!-- Image -->
                                    <div class="col-md-4 position-relative">
                                        @if ($item->image_url)
                                            <div class="position-relative overflow-hidden h-100">
                                                <img src="{{ asset('storage/' . $item->image_url) }}"
                                                    class="img-fluid w-100 h-100" alt="{{ $item->title }}"
                                                    style="object-fit: cover; min-height: 200px;">
                                            </div>
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100"
                                                style="min-height: 200px;">
                                                <i class="fas fa-newspaper text-primary fa-3x opacity-50"></i>
                                            </div>
                                        @endif

                                        <!-- Date Badge -->
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-primary text-white px-3 py-2 rounded-pill shadow">
                                                <i class="fa fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="col-md-8">
                                        <div class="card-body h-100 d-flex flex-column p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h3 class="card-title h4 mb-2 text-dark">{{ $item->title }}</h3>
                                                    <p class="text-muted small mb-3">
                                                        ID Berita: #{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Detail Berita -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="fas fa-clock me-2 text-primary"
                                                                style="width: 16px;"></i>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="fas fa-user me-2 text-primary"
                                                                style="width: 16px;"></i>
                                                            Admin
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="fas fa-eye me-2 text-primary"
                                                                style="width: 16px;"></i>
                                                            Dipublikasi: {{ $item->created_at->format('d M Y H:i') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Konten Preview -->
                                            <p class="card-text flex-grow-1 text-muted mb-3 line-clamp-3">
                                                {{ Str::limit(strip_tags($item->content), 200) }}
                                            </p>

                                            <!-- Actions -->
                                            <div class="d-flex gap-2 mt-auto">
                                                <a href="{{ route('member.berita.show', $item->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-2"></i>
                                                    Baca Selengkapnya
                                                </a>
                                                <button class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-share-alt me-2"></i>
                                                    Bagikan
                                                </button>
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
                        <i class="fas fa-newspaper text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="h4 text-muted mb-4">Belum Ada Berita</h3>
                    <p class="text-muted mb-4">
                        @if (request('search'))
                            Tidak ditemukan berita dengan kata kunci "{{ request('search') }}"
                        @else
                            Maaf, saat ini belum ada berita yang tersedia.
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('member.berita.index') }}" class="btn btn-primary rounded-pill py-3 px-5">
                            <i class="fas fa-search me-2"></i>
                            Lihat Semua Berita
                        </a>
                    @else
                        <a href="{{ route('member.home') }}" class="btn btn-primary rounded-pill py-3 px-5">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <!-- Berita Section End -->
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hero-header {
            background: linear-gradient(rgba(19, 53, 123, 0.8), rgba(19, 53, 123, 0.8)), url('assets/img/carousel-2.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }
    </style>
@endpush
