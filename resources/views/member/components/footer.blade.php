<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6 col-md-6">
                <div class="footer-item">
                    <h4 class="text-white mb-3">NearMe</h4>
                    <p class="mb-4">Menjelajahi keindahan Indonesia dengan pengalaman wisata yang tak terlupakan.
                        Kami hadir untuk memberikan pelayanan terbaik dalam setiap perjalanan Anda.</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social me-2" href="#"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social me-2" href="#"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social me-2" href="#"><i
                                class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-white mb-3">Menu Utama</h4>
                    <div class="d-flex flex-column">
                        <a href="{{ route('member.home') }}" class="btn btn-link text-light p-0 mb-2 text-start">
                            <i class="fas fa-chevron-right me-2"></i>Beranda
                        </a>
                        <a href="{{ route('member.paket-wisata.index') }}"
                            class="btn btn-link text-light p-0 mb-2 text-start">
                            <i class="fas fa-chevron-right me-2"></i>Paket Wisata
                        </a>
                        <a href="{{ route('member.galeri.index') }}"
                            class="btn btn-link text-light p-0 mb-2 text-start">
                            <i class="fas fa-chevron-right me-2"></i>Galeri
                        </a>
                        <a href="{{ route('member.video.index') }}" class="btn btn-link text-light p-0 mb-2 text-start">
                            <i class="fas fa-chevron-right me-2"></i>Video
                        </a>
                        <a href="{{ route('member.berita.index') }}"
                            class="btn btn-link text-light p-0 mb-2 text-start">
                            <i class="fas fa-chevron-right me-2"></i>Berita
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-white mb-3">Hubungi Kami</h4>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-map-marker-alt me-3 text-primary"></i>
                            <span>Jl. Sudirman No. 123, Jakarta Pusat, Indonesia</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-phone-alt me-3 text-primary"></i>
                            <span>+62 21 1234 5678</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-envelope me-3 text-primary"></i>
                            <span>info@nearme.com</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-clock me-3 text-primary"></i>
                            <span>Senin - Jumat: 08:00 - 17:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Footer End -->

<style>
    .btn-social {
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-social:hover {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        transform: translateY(-2px);
    }

    .footer-item .btn-link {
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-item .btn-link:hover {
        color: var(--bs-primary) !important;
        text-decoration: none;
        padding-left: 5px;
    }

    .footer-item .btn-link:hover i {
        color: var(--bs-primary);
    }
</style>
