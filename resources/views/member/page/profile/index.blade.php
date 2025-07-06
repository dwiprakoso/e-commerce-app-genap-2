@extends('member.layouts.app')
@section('content')
    <!-- Hero Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Profile Saya</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Informasi akun dan data personal Anda</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Header End -->

    <!-- Profile Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Profile Card -->
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card border-0 shadow card-hover h-100">
                        <div class="card-header bg-primary text-white p-4">
                            <div class="position-relative">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="rounded-circle bg-white p-3 shadow">
                                        <i class="fas fa-user text-primary fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="card-title mb-3">{{ $user->name }}</h3>
                            <p class="text-muted mb-3">{{ $user->email }}</p>
                            <div class="d-flex align-items-center justify-content-center mb-4">
                                <small class="text-primary">
                                    <i class="fa fa-calendar-alt me-2"></i>
                                    Bergabung {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}
                                </small>
                            </div>
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                ID: #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card border-0 shadow card-hover h-100">
                        <div class="card-header bg-secondary text-white p-4">
                            <h4 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Akun
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                                    <div class="bg-light rounded p-3 border">
                                        <span class="text-dark">{{ $user->name }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Email</label>
                                    <div class="bg-light rounded p-3 border">
                                        <span class="text-dark">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Tanggal Bergabung</label>
                                    <div class="bg-light rounded p-3 border">
                                        <span
                                            class="text-dark">{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y, H:i') }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Terakhir Update</label>
                                    <div class="bg-light rounded p-3 border">
                                        <span
                                            class="text-dark">{{ \Carbon\Carbon::parse($user->updated_at)->format('d F Y, H:i') }}</span>
                                    </div>
                                </div>
                                @if ($user->provider)
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">Login Via</label>
                                        <div class="bg-light rounded p-3 border">
                                            <span class="text-dark text-capitalize">{{ $user->provider }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Section End -->

    <!-- Account Status Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Status Akun</h6>
                <h1 class="mb-5">Informasi Keanggotaan</h1>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="card border-0 shadow card-hover h-100 text-center">
                        <div class="card-body p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                            <h4 class="text-success mb-3">Aktif</h4>
                            <p class="text-muted">Akun Terverifikasi</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card border-0 shadow card-hover h-100 text-center">
                        <div class="card-body p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user-shield text-primary fa-2x"></i>
                            </div>
                            <h4 class="text-primary mb-3">Member</h4>
                            <p class="text-muted">Status Keanggotaan</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="card border-0 shadow card-hover h-100 text-center">
                        <div class="card-body p-4">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-clock text-secondary fa-2x"></i>
                            </div>
                            <h4 class="text-secondary mb-3">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                            </h4>
                            <p class="text-muted">Bergabung</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Account Status End -->

    <!-- Action Buttons Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('member.paket-wisata.index') }}" class="btn btn-primary rounded-pill py-3 px-5">
                        <i class="fas fa-map-marked-alt me-2"></i>
                        Jelajahi Paket Wisata
                    </a>
                    <a href="{{ route('member.home') }}" class="btn btn-secondary rounded-pill py-3 px-5">
                        <i class="fas fa-home me-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Action Buttons End -->
@endsection

@push('styles')
    <style>
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .hero-header {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .slideInDown {
            animation-name: slideInDown;
        }

        @keyframes slideInDown {
            from {
                transform: translate3d(0, -100%, 0);
                visibility: visible;
            }

            to {
                transform: translate3d(0, 0, 0);
            }
        }
    </style>
@endpush
