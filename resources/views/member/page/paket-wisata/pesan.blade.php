@extends('member.layouts.app')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary py-5 page-header">
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-3 text-white animated slideInDown mb-4">Pesan Paket Wisata</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb text-uppercase mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.home') }}" class="text-white">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.paket-wisata.index') }}" class="text-white">Paket Wisata</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('member.paket-wisata.show', $paket->id) }}"
                                    class="text-white">{{ $paket->title }}</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Pemesanan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Booking Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-5">
                        <!-- Package Detail Card -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow h-100">
                                <!-- Package Image -->
                                <div class="position-relative">
                                    <div class="bg-gradient-primary d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        @if ($paket->image_url)
                                            <img src="{{ asset('storage/' . $paket->image_url) }}" alt="{{ $paket->title }}"
                                                class="card-img-top" style="height: 250px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-image text-white fa-4x opacity-50"></i>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    <h3 class="card-title mb-3 fw-bold">{{ $paket->title }}</h3>
                                    <p class="card-text text-muted mb-4">{{ $paket->description }}</p>

                                    <!-- Package Info -->
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                                            <span
                                                class="text-muted">{{ \Carbon\Carbon::parse($paket->start_date)->format('d M Y') }}
                                                - {{ \Carbon\Carbon::parse($paket->end_date)->format('d M Y') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <span
                                                class="text-muted">{{ \Carbon\Carbon::parse($paket->start_date)->diffInDays(\Carbon\Carbon::parse($paket->end_date)) + 1 }}
                                                Hari</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-tag text-primary me-2"></i>
                                            <span class="fw-bold text-success fs-5">Rp
                                                {{ number_format($paket->price, 0, ',', '.') }} / orang</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Form -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow h-100">
                                <div class="card-body p-4">
                                    <h3 class="card-title mb-4 fw-bold">Data Pemesanan</h3>

                                    <form action="{{ route('member.paket-wisata.store-pesan', $paket->id) }}"
                                        method="POST" id="pesanForm" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Jumlah Orang -->
                                        <div class="mb-4">
                                            <label for="jumlah_orang" class="form-label fw-semibold">
                                                <i class="fas fa-users me-2 text-primary"></i>Jumlah Orang
                                            </label>
                                            <input type="number" id="jumlah_orang" name="jumlah_orang"
                                                class="form-control form-control-lg @error('jumlah_orang') is-invalid @enderror"
                                                placeholder="Masukkan jumlah orang" value="{{ old('jumlah_orang', 1) }}"
                                                min="1" max="50" oninput="hitungTotal()"
                                                onchange="hitungTotal()" onkeyup="hitungTotal()">
                                            @error('jumlah_orang')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Total Harga -->
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                <i class="fas fa-calculator me-2 text-primary"></i>Total Harga
                                            </label>
                                            <div class="form-control form-control-lg bg-light fw-bold text-success fs-5"
                                                id="totalHarga">
                                                Rp {{ number_format($paket->price, 0, ',', '.') }}
                                            </div>
                                            <input type="hidden" id="total_harga_hidden" name="total_harga"
                                                value="{{ $paket->price }}">
                                        </div>

                                        <!-- Upload Bukti Bayar (Opsional) -->
                                        <div class="mb-4">
                                            <label for="bukti_bayar" class="form-label fw-semibold">
                                                <i class="fas fa-receipt me-2 text-primary"></i>Bukti Pembayaran
                                                <span class="text-muted">(Opsional)</span>
                                            </label>
                                            <input type="file" id="bukti_bayar" name="bukti_bayar"
                                                class="form-control @error('bukti_bayar') is-invalid @enderror"
                                                accept="image/*">
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Format: JPG, PNG, JPEG. Maksimal 2MB. Jika tidak diupload sekarang,
                                                dapat diupload nanti di halaman "Pesanan Saya".
                                            </div>
                                            @error('bukti_bayar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Informasi Pembayaran -->
                                        <div class="alert alert-info border-0 shadow-sm mb-4">
                                            <h6 class="alert-heading fw-bold">
                                                <i class="fas fa-info-circle me-2"></i>Informasi Pembayaran
                                            </h6>
                                            <p class="mb-0 small">
                                                Transfer ke rekening: <br>
                                                <strong>Bank BCA: 1234567890</strong><br>
                                                <strong>A.n: PT NearMe</strong><br>
                                                <span class="text-muted">Bukti pembayaran dapat diupload sekarang atau nanti
                                                    di halaman "Pesanan Saya".</span>
                                            </p>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2 d-md-flex">
                                            <a href="{{ route('member.paket-wisata.show', $paket->id) }}"
                                                class="btn btn-secondary btn-lg flex-md-fill me-md-2">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Kembali
                                            </a>
                                            <button type="submit" class="btn btn-success btn-lg flex-md-fill"
                                                onclick="return validateForm()">
                                                <i class="fas fa-check me-2"></i>
                                                Pesan Sekarang
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Global variables
        const HARGA_PER_ORANG = {{ $paket->price }};

        console.log('=== INLINE SCRIPT LOADED ===');
        console.log('Harga per orang:', HARGA_PER_ORANG);

        // Fungsi untuk format rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi untuk menghitung total harga
        function hitungTotal() {
            console.log('=== MENGHITUNG TOTAL ===');

            const inputJumlah = document.getElementById('jumlah_orang');
            const displayTotal = document.getElementById('totalHarga');
            const hiddenTotal = document.getElementById('total_harga_hidden');

            if (!inputJumlah || !displayTotal) {
                console.error('Element tidak ditemukan!');
                return;
            }

            let jumlahOrang = parseInt(inputJumlah.value) || 1;

            // Validasi input
            if (jumlahOrang < 1) {
                jumlahOrang = 1;
                inputJumlah.value = 1;
            }
            if (jumlahOrang > 50) {
                jumlahOrang = 50;
                inputJumlah.value = 50;
            }

            const totalHarga = HARGA_PER_ORANG * jumlahOrang;

            console.log('Jumlah orang:', jumlahOrang);
            console.log('Total harga:', totalHarga);

            // Update display
            displayTotal.textContent = formatRupiah(totalHarga);

            // Update hidden input
            if (hiddenTotal) {
                hiddenTotal.value = totalHarga;
            }

            console.log('Display updated:', displayTotal.textContent);
        }

        // Fungsi validasi form
        function validateForm() {
            const jumlahOrang = parseInt(document.getElementById('jumlah_orang').value);

            if (!jumlahOrang || jumlahOrang < 1) {
                alert('Jumlah orang minimal 1!');
                document.getElementById('jumlah_orang').focus();
                return false;
            }

            return true;
        }

        // Validate file on selection
        document.getElementById('bukti_bayar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                e.target.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG.');
                e.target.value = '';
                return;
            }
        });

        // Hitung total saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - running initial calculation');
            hitungTotal();
        });

        // Backup: Hitung ulang setelah 1 detik
        setTimeout(function() {
            console.log('Backup calculation after 1 second');
            hitungTotal();
        }, 1000);

        console.log('=== SCRIPT INITIALIZATION COMPLETE ===');
    </script>
@endpush

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .alert-info {
            background-color: rgba(13, 202, 240, 0.1);
            border-left: 4px solid #0dcaf0;
        }
    </style>
@endpush
