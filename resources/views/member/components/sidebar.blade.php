<!-- Navbar & Hero Start -->
<div class="container-fluid navbar-container p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 shadow-sm">
        <a href="{{ route('member.home') }}" class="navbar-brand p-0 d-flex align-items-center">
            <i class="fa fa-map-marker-alt me-3 text-primary fs-1 brand-icon"></i>
            <h1 class="m-0 text-primary brand-text" style="font-family: 'Jost', sans-serif;">NearMe</h1>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars text-primary"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('member.home') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.home') ? 'active' : '' }} nav-link-custom">
                    <i class="fas fa-home me-1"></i>Beranda
                </a>
                <a href="{{ route('member.paket-wisata.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.paket-wisata.*') ? 'active' : '' }} nav-link-custom">
                    <i class="fas fa-suitcase me-1"></i>Paket Wisata
                </a>
                <a href="{{ route('member.galeri.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.galeri.*') ? 'active' : '' }} nav-link-custom">
                    <i class="fas fa-images me-1"></i>Galeri
                </a>
                <a href="{{ route('member.video.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.video.*') ? 'active' : '' }} nav-link-custom">
                    <i class="fas fa-play-circle me-1"></i>Video
                </a>
                <a href="{{ route('member.berita.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('member.berita.*') ? 'active' : '' }} nav-link-custom">
                    <i class="fas fa-newspaper me-1"></i>Berita
                </a>
            </div>
            <div class="ms-lg-4 d-flex align-items-center">
                @guest('member')
                    <a href="{{ route('member.login') }}" class="btn btn-primary rounded-pill py-2 px-4 me-2 btn-custom">
                        <i class="fas fa-sign-in-alt me-1"></i>Masuk
                    </a>
                    <a href="{{ route('member.register') }}"
                        class="btn btn-outline-primary rounded-pill py-2 px-4 btn-custom">
                        <i class="fas fa-user-plus me-1"></i>Daftar
                    </a>
                @else
                    <div class="dropdown">
                        <a href="#"
                            class="dropdown-toggle d-flex align-items-center text-decoration-none user-dropdown"
                            data-bs-toggle="dropdown">
                            <div
                                class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                <i class="fa fa-user"></i>
                            </div>
                            <span class="user-name">{{ Auth::guard('member')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom shadow">
                            <li class="dropdown-header">
                                <small class="text-muted">Selamat datang,
                                    {{ Auth::guard('member')->user()->name }}!</small>
                            </li>
                            <li>
                                <a href="{{ route('member.pesanan') }}" class="dropdown-item dropdown-item-custom">
                                    <i class="fas fa-shopping-bag me-2 text-primary"></i>Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.profile') }}" class="dropdown-item dropdown-item-custom">
                                    <i class="fas fa-shopping-bag me-2 text-primary"></i>Profil Saya
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('member.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-item-custom text-danger">
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

<style>
    /* Brand Styling */
    .brand-icon {
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover .brand-icon {
        transform: scale(1.1);
    }

    .brand-text {
        transition: color 0.3s ease;
    }

    /* Navigation Links */
    .nav-link-custom {
        position: relative;
        padding: 0.75rem 1rem !important;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }

    .nav-link-custom:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary) !important;
        transform: translateY(-2px);
    }

    .nav-link-custom.active {
        background-color: var(--bs-primary);
        color: white !important;
        box-shadow: 0 4px 15px rgba(var(--bs-primary-rgb), 0.3);
    }

    .nav-link-custom.active:hover {
        color: white !important;
        transform: translateY(-2px);
    }

    /* Button Styling */
    .btn-custom {
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    /* User Dropdown */
    .user-avatar {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }

    .user-dropdown {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .user-dropdown:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary) !important;
    }

    .user-name {
        font-weight: 500;
        color: var(--bs-dark);
    }

    /* Dropdown Menu */
    .dropdown-menu-custom {
        border: none;
        border-radius: 0.75rem;
        min-width: 200px;
        padding: 0.5rem 0;
        margin-top: 0.5rem;
    }

    .dropdown-item-custom {
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
        border-radius: 0;
    }

    .dropdown-item-custom:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        padding-left: 1.5rem;
    }

    .dropdown-header {
        padding: 0.75rem 1.25rem 0.5rem;
    }

    /* Navbar Toggler */
    .navbar-toggler:focus {
        box-shadow: none;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .nav-link-custom {
            margin: 0.25rem 0;
        }

        .navbar-nav {
            padding-top: 1rem;
        }

        .ms-lg-4 {
            margin-top: 1rem !important;
            margin-left: 0 !important;
        }
    }
</style>
