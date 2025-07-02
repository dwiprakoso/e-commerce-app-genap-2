<!-- Navbar & Hero Start -->
<div class="container-fluid navbar-container p-0">
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


</div>
<!-- Navbar & Hero End -->
