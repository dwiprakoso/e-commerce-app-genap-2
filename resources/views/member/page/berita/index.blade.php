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
            @if ($berita->count() > 0)
                <div class="row g-4">
                    @foreach ($berita as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                @if ($item->image_url)
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top"
                                            alt="{{ $item->title }}" style="height: 250px; object-fit: cover;">
                                        <!-- Date Badge -->
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow">
                                                <i class="fa fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center position-relative"
                                        style="height: 250px;">
                                        <i class="fas fa-newspaper text-primary fa-3x opacity-50"></i>
                                        <!-- Date Badge -->
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow">
                                                <i class="fa fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="card-title mb-3 line-clamp-2">{{ $item->title }}</h5>
                                    <p class="card-text flex-grow-1 text-muted line-clamp-3">
                                        {{ Str::limit(strip_tags($item->content), 150) }}</p>

                                    <!-- Meta Info -->
                                    <div class="d-flex align-items-center text-muted mb-3">
                                        <small><i class="fas fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('member.berita.show', $item->id) }}" class="btn btn-primary mt-auto">
                                        <i class="fas fa-eye me-2"></i>Baca Selengkapnya
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
                        <i class="fas fa-newspaper text-muted fa-5x mb-3"></i>
                    </div>
                    <h3 class="text-muted mb-4">Belum Ada Berita</h3>
                    <p class="text-muted mb-4">
                        @if (request('search'))
                            Tidak ditemukan berita dengan kata kunci "{{ request('search') }}"
                        @else
                            Maaf, saat ini belum ada berita yang tersedia.
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('member.berita.index') }}" class="btn btn-primary rounded-pill py-3 px-5">
                            Lihat Semua Berita
                        </a>
                    @else
                        <a href="{{ route('member.home') }}" class="btn btn-primary rounded-pill py-3 px-5">
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
    </style>
@endpush
