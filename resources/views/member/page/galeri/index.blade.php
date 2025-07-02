@extends('member.layouts.app')
@section('content')
    <!-- Hero Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Galeri Foto</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Koleksi foto-foto indah dari berbagai destinasi
                        wisata di Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Header End -->

    <!-- Gallery Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if ($galleries->count() > 0)
                <div class="row g-4">
                    @foreach ($galleries as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="gallery-item rounded overflow-hidden shadow card-hover" style="cursor: pointer;"
                                onclick="openModal('{{ $item->id }}')">
                                <!-- Image -->
                                <div class="position-relative"
                                    style="height: 250px; background: linear-gradient(135deg, #6c63ff, #ff6b9d);">
                                    @if ($item->image_url)
                                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->caption }}"
                                            class="img-fluid w-100 h-100"
                                            style="object-fit: cover; transition: transform 0.3s ease;">
                                    @else
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <i class="fas fa-image text-white fa-3x" style="opacity: 0.5;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Caption -->
                                @if ($item->caption)
                                    <div class="p-3 bg-white">
                                        <p class="text-muted mb-1 small text-truncate-2">{{ $item->caption }}</p>
                                        <p class="text-secondary mb-0" style="font-size: 0.75rem;">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox Modal -->
                <div class="modal fade" id="lightboxModal" tabindex="-1" style="background: rgba(0,0,0,0.95);">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close btn-close-white" onclick="closeModal()"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0 position-relative">
                                <!-- Image Container -->
                                <div class="text-center position-relative">
                                    <img id="modalImage" src="" alt="" class="img-fluid"
                                        style="max-height: 80vh; object-fit: contain;">

                                    <!-- Navigation -->
                                    <button type="button"
                                        class="btn position-absolute top-50 start-0 translate-middle-y ms-3"
                                        onclick="prevImage()"
                                        style="background: rgba(255,255,255,0.2); border: none; color: white; font-size: 1.5rem; width: 50px; height: 50px; border-radius: 50%;">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button"
                                        class="btn position-absolute top-50 end-0 translate-middle-y me-3"
                                        onclick="nextImage()"
                                        style="background: rgba(255,255,255,0.2); border: none; color: white; font-size: 1.5rem; width: 50px; height: 50px; border-radius: 50%;">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>

                                <!-- Caption -->
                                <div id="modalCaption" class="text-white text-center mt-3 px-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-images text-muted fa-5x"></i>
                    </div>
                    <h3 class="h3 text-muted mb-3">Belum Ada Foto</h3>
                    <p class="text-muted mb-4">
                        @if (request('search'))
                            Tidak ditemukan foto dengan kata kunci "{{ request('search') }}"
                        @else
                            Maaf, saat ini belum ada foto yang tersedia di galeri.
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('member.galeri.index') }}" class="btn btn-primary rounded-pill py-3 px-5">
                            Lihat Semua Foto
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
    <!-- Gallery Section End -->
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

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        #lightboxModal {
            display: none;
        }

        #lightboxModal.show {
            display: flex !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let galleries = @json($galleries);
        let currentIndex = 0;

        function openModal(id) {
            const modal = document.getElementById('lightboxModal');
            const modalImage = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');

            // Find the gallery item
            const gallery = galleries.find(item => item.id == id);
            currentIndex = galleries.findIndex(item => item.id == id);

            if (gallery && gallery.image_url) {
                modalImage.src = '/storage/' + gallery.image_url;
                modalImage.alt = gallery.caption || '';
                modalCaption.textContent = gallery.caption || '';

                modal.style.display = 'flex';
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal() {
            const modal = document.getElementById('lightboxModal');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function nextImage() {
            if (currentIndex < galleries.length - 1) {
                currentIndex++;
                const gallery = galleries[currentIndex];
                if (gallery.image_url) {
                    const modalImage = document.getElementById('modalImage');
                    const modalCaption = document.getElementById('modalCaption');

                    modalImage.src = '/storage/' + gallery.image_url;
                    modalImage.alt = gallery.caption || '';
                    modalCaption.textContent = gallery.caption || '';
                }
            }
        }

        function prevImage() {
            if (currentIndex > 0) {
                currentIndex--;
                const gallery = galleries[currentIndex];
                if (gallery.image_url) {
                    const modalImage = document.getElementById('modalImage');
                    const modalCaption = document.getElementById('modalCaption');

                    modalImage.src = '/storage/' + gallery.image_url;
                    modalImage.alt = gallery.caption || '';
                    modalCaption.textContent = gallery.caption || '';
                }
            }
        }

        // Close modal when clicking outside
        document.getElementById('lightboxModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            }
        });
    </script>
@endpush
