@extends('member.layouts.app')
@section('content')
    <!-- Hero Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Mari Jelajahi Indonesia Bersama!
                    </h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Temukan destinasi wisata terbaik di
                        Nusantara dengan paket wisata yang menarik dan terpercaya</p>
                    <div class="position-relative w-75 mx-auto animated slideInDown">
                        <a href="{{ route('member.paket-wisata.index') }}" class="btn hero-btn text-white py-3 px-5">
                            Jelajahi Sekarang <i class="fa fa-arrow-right ms-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Header End -->
    <!-- Berita Terbaru Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Berita & Artikel</h6>
                <h1 class="mb-5">Update Terbaru Dunia Pariwisata</h1>
            </div>

            @if ($berita->count() > 0)
                <div class="row g-4">
                    @foreach ($berita as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                @if ($item->image_url)
                                    <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top"
                                        alt="{{ $item->title }}" style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="fas fa-newspaper text-primary fa-3x"></i>
                                    </div>
                                @endif
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex mb-3">
                                        <small class="text-primary"><i class="fa fa-calendar-alt me-1"></i>
                                            {{ $item->created_at->format('d M Y') }}</small>
                                    </div>
                                    <h5 class="card-title mb-3">{{ $item->title }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($item->content), 120) }}
                                    </p>
                                    <a href="{{ route('member.berita.show', $item->id) }}" class="btn btn-primary mt-auto">
                                        Baca Selengkapnya <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper text-muted fa-5x mb-3"></i>
                    <h5 class="text-muted">Belum ada berita tersedia</h5>
                    <p class="text-muted">Nantikan update berita terbaru dari kami</p>
                </div>
            @endif

            <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('member.berita.index') }}" class="btn btn-secondary rounded-pill py-3 px-5">
                    Lihat Semua Berita <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Berita Terbaru End -->

    <!-- Video Section Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Video Wisata</h6>
                <h1 class="mb-5">Saksikan Keindahan Destinasi</h1>
            </div>

            @if ($videos->count() > 0)
                <div class="row g-4">
                    @foreach ($videos as $video)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="card border-0 shadow card-hover h-100">
                                <div class="position-relative">
                                    @php
                                        $videoId = '';
                                        if (str_contains($video->url, 'youtube.com/watch?v=')) {
                                            parse_str(parse_url($video->url, PHP_URL_QUERY), $params);
                                            $videoId = $params['v'] ?? '';
                                        } elseif (str_contains($video->url, 'youtu.be/')) {
                                            $videoId = basename(parse_url($video->url, PHP_URL_PATH));
                                        } elseif (str_contains($video->url, 'youtube.com/embed/')) {
                                            $videoId = basename(parse_url($video->url, PHP_URL_PATH));
                                        }
                                    @endphp
                                    @if ($videoId)
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                                            alt="{{ $video->title }}" class="card-img-top"
                                            style="height: 250px; object-fit: cover;" />
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <i class="fas fa-play-circle text-white fa-4x opacity-75"></i>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light"
                                            style="height: 250px;">
                                            <i class="fas fa-video text-primary fa-4x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex mb-3">
                                        <small class="text-secondary"><i class="fas fa-video me-1"></i> Video
                                            Wisata</small>
                                    </div>
                                    <h5 class="card-title mb-3">{{ $video->title }}</h5>
                                    @if ($video->description)
                                        <p class="card-text flex-grow-1">{{ Str::limit($video->description, 120) }}
                                        </p>
                                    @endif
                                    <a href="{{ route('member.video.show', $video->id) }}"
                                        class="btn btn-secondary mt-auto">
                                        Tonton Video <i class="fas fa-play ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-video text-muted fa-5x mb-3"></i>
                    <h5 class="text-muted">Belum ada video tersedia</h5>
                    <p class="text-muted">Nantikan video wisata menarik dari kami</p>
                </div>
            @endif

            <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('member.video.index') }}" class="btn btn-primary rounded-pill py-3 px-5">
                    Lihat Semua Video <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Video Section End -->

    <!-- Gallery Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Galeri Foto</h6>
                <h1 class="mb-5">Koleksi Foto Indah Destinasi</h1>
            </div>

            @if ($galleries->count() > 0)
                <div class="row g-4">
                    @foreach ($galleries->take(6) as $gallery)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="gallery-item rounded overflow-hidden shadow">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $gallery->image_url) }}" alt="{{ $gallery->caption }}"
                                        class="img-fluid w-100 gallery-image"
                                        style="height: 300px; object-fit: cover; transition: transform 0.3s ease;">
                                </div>
                                <div class="p-3 bg-white">
                                    <h5 class="mb-2">{{ $gallery->caption }}</h5>
                                    <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i>
                                        {{ $gallery->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images text-muted fa-5x mb-3"></i>
                    <h5 class="text-muted">Belum ada foto tersedia</h5>
                    <p class="text-muted">Nantikan koleksi foto indah dari berbagai destinasi</p>
                </div>
            @endif

            <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('member.galeri.index') }}" class="btn btn-secondary rounded-pill py-3 px-5">
                    Lihat Semua Foto <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Gallery Section End -->
@endsection
@push('styles')
    <style>
        .gallery-item .gallery-image {
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        /* Optional: Add cursor pointer to indicate it's interactive */
        .gallery-item {
            cursor: pointer;
        }

        /* Optional: Add subtle shadow effect on hover */
        .gallery-item:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
        }
    </style>
@endpush
