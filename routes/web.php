<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PaketWisataController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect()->route('member.login');
})->name('login');
// Member Routes (Public)
Route::get('/', [MemberDashboardController::class, 'home'])->name('member.home');
Route::get('/test-view', [MemberDashboardController::class, 'indexTest'])->name('member.index.test');

// Member Auth Routes
Route::prefix('member')->group(function () {
    // Guest routes (tidak perlu login)
    Route::middleware('guest:member')->group(function () {
        // Auth form routes
        Route::get('/login', [MemberAuthController::class, 'showLoginForm'])->name('member.login');
        Route::post('/login', [MemberAuthController::class, 'login'])->name('member.login.post');

        Route::get('/register', [MemberAuthController::class, 'showRegisterForm'])->name('member.register');
        Route::post('/register', [MemberAuthController::class, 'register'])->name('member.register.post');

        // Social login routes
        Route::get('/auth/{provider}', [MemberAuthController::class, 'redirectToProvider'])->name('member.social.redirect');
        Route::get('/auth/{provider}/callback', [MemberAuthController::class, 'handleProviderCallback'])->name('member.social.callback');
    });
    // Paket Wisata Routes
    Route::get('/paket-wisata', [MemberDashboardController::class, 'paketWisata'])->name('member.paket-wisata.index');
    Route::get('/paket-wisata/{id}', [MemberDashboardController::class, 'detailPaketWisata'])->name('member.paket-wisata.show');
    // Berita Routes
    Route::get('/berita', [MemberDashboardController::class, 'berita'])->name('member.berita.index');
    Route::get('/berita/{id}', [MemberDashboardController::class, 'detailBerita'])->name('member.berita.show');
    // Video Routes
    Route::get('/video', [MemberDashboardController::class, 'video'])->name('member.video.index');
    Route::get('/video/{id}', [MemberDashboardController::class, 'detailVideo'])->name('member.video.show');
    // Galeri Routes
    Route::get('/galeri', [MemberDashboardController::class, 'gallery'])->name('member.galeri.index');

    // Authenticated member routes
    Route::middleware('auth:member')->group(function () {
        Route::get('/paket-wisata/{id}/pesan', [MemberController::class, 'formPesan'])->name('member.paket-wisata.pesan');
        Route::post('/paket-wisata/{id}/pesan', [MemberController::class, 'storePesan'])->name('member.paket-wisata.store-pesan');
        Route::get('/pesanan-saya', [MemberController::class, 'pesananSaya'])->name('member.pesanan');
        Route::post('/pesanan/{id}/upload-bukti', [MemberController::class, 'uploadBuktiPembayaran'])->name('member.pesanan.upload-bukti');
        Route::get('/profile', [MemberDashboardController::class, 'profile'])->name('member.profile');
        Route::post('/logout', [MemberAuthController::class, 'logout'])->name('member.logout');
    });
});

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/', [PemesananController::class, 'index'])->name('admin.index');

        Route::prefix('paket-wisata')->group(function () {
            Route::get('/', [PaketWisataController::class, 'index'])->name('admin.paket-wisata.index');
            Route::get('/create', [PaketWisataController::class, 'create'])->name('admin.paket-wisata.create');
            Route::post('/store', [PaketWisataController::class, 'store'])->name('admin.paket-wisata.store');
            Route::get('/edit/{id}', [PaketWisataController::class, 'edit'])->name('admin.paket-wisata.edit');
            Route::put('/update/{id}', [PaketWisataController::class, 'update'])->name('admin.paket-wisata.update');
            Route::delete('/delete/{id}', [PaketWisataController::class, 'destroy'])->name('admin.paket-wisata.destroy');
        });

        Route::prefix('gallery')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('admin.gallery.index');
            Route::get('/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
            Route::post('/store', [GalleryController::class, 'store'])->name('admin.gallery.store');
            Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
            Route::put('/update/{id}', [GalleryController::class, 'update'])->name('admin.gallery.update');
            Route::delete('/delete/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
        });

        Route::prefix('video')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('admin.video.index');
            Route::get('/create', [VideoController::class, 'create'])->name('admin.video.create');
            Route::post('/store', [VideoController::class, 'store'])->name('admin.video.store');
            Route::get('/edit/{id}', [VideoController::class, 'edit'])->name('admin.video.edit');
            Route::put('/update/{id}', [VideoController::class, 'update'])->name('admin.video.update');
            Route::delete('/delete/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');
        });

        Route::prefix('berita')->group(function () {
            Route::get('/', [BeritaController::class, 'index'])->name('admin.berita.index');
            Route::get('/create', [BeritaController::class, 'create'])->name('admin.berita.create');
            Route::post('/store', [BeritaController::class, 'store'])->name('admin.berita.store');
            Route::get('/edit/{id}', [BeritaController::class, 'edit'])->name('admin.berita.edit');
            Route::put('/update/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');
            Route::delete('/delete/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
        });

        Route::prefix('pemesanan')->group(function () {
            Route::get('/', [PemesananController::class, 'index'])->name('admin.pemesanan.index');
            Route::get('/edit/{id}', [PemesananController::class, 'edit'])->name('admin.pemesanan.edit');
            Route::put('/update/{id}', [PemesananController::class, 'update'])->name('admin.pemesanan.update');
            Route::get('/export-excel', [PemesananController::class, 'exportExcel'])->name('admin.pemesanan.export.excel');
            Route::get('/export-pdf', [PemesananController::class, 'exportPdf'])->name('admin.pemesanan.export.pdf');
        });

        Route::prefix('member')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('admin.member.index');
            Route::delete('/delete/{id}', [MemberController::class, 'destroy'])->name('admin.member.destroy');
        });
    });
});
