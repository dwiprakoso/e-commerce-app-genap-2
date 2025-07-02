<!-- Navbar & Hero Start -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ route('member.home') }}" class="navbar-brand p-0 d-flex align-items-center">
            <i class="fa fa-map-marker-alt me-3 text-primary fs-1"></i>
            <h1 class="m-0 text-primary" style="font-family: 'Jost', sans-serif;">Wisata Nusantara</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('member.home') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('member.paket-wisata.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.paket-wisata.*') ? 'active' : '' }}">Paket
                    Wisata</a>
                <a href="{{ route('member.galeri.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.galeri.*') ? 'active' : '' }}">Galeri</a>
                <a href="{{ route('member.video.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.video.*') ? 'active' : '' }}">Video</a>
                <a href="{{ route('member.berita.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.berita.*') ? 'active' : '' }}">Berita</a>
            </div>
            <div class="ms-lg-4 d-flex align-items-center">
                @guest('member')
                    <a href="{{ route('member.login') }}" class="btn btn-primary rounded-pill py-2 px-4 me-2">Masuk</a>
                    <a href="{{ route('member.register') }}"
                        class="btn btn-outline-primary rounded-pill py-2 px-4">Daftar</a>
                @else
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle d-flex align-items-center text-decoration-none"
                            data-bs-toggle="dropdown">
                            <i class="fa fa-user-circle fa-2x text-primary me-2"></i>
                            <span>{{ Auth::guard('member')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('member.pesanan') }}" class="dropdown-item"><i
                                        class="fas fa-shopping-bag me-2"></i>Pesanan Saya</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('member.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

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
</div>
<!-- Navbar & Hero End -->
