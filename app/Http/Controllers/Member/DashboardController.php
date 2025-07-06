<?php

namespace App\Http\Controllers\Member;

use App\Models\Video;
use App\Models\Berita;
use App\Models\Member;
use App\Models\Gallery;
use App\Models\PaketWisata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        // Paket Wisata Terbaru (6 items untuk showcase)
        $paketWisata = PaketWisata::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Berita Terbaru (3 items untuk preview)
        $berita = Berita::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Video Terbaru (3 items untuk preview)
        $videos = Video::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Gallery Terbaru (6 items untuk showcase visual)
        $galleries = Gallery::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Statistik untuk menunjukkan kredibilitas
        $stats = [
            'total_paket' => PaketWisata::where('status', 'aktif')->count(),
            'total_berita' => Berita::count(),
            'total_video' => Video::count(),
            'total_gallery' => Gallery::count()
        ];

        // Paket Wisata Populer/Terlaris (berdasarkan created_at atau bisa ditambah field popularity)
        $paketPopuler = PaketWisata::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('member.page.home', compact(
            'paketWisata',
            'berita',
            'videos',
            'galleries',
            'stats',
            'paketPopuler'
        ));
    }
    public function profile()
    {
        // Cara yang lebih efisien - langsung query berdasarkan ID
        $user = Member::find(Auth::id());

        // Alternatif lain yang juga benar:
        // $user = Member::where('id', Auth::id())->first();
        // $user = Auth::user(); // Jika sudah setup guard dengan model Member

        return view('member.page.profile.index', compact('user'));
    }

    public function paketWisata(Request $request)
    {
        $query = PaketWisata::query();

        // Filter hanya yang berstatus publish
        $query->where('status', 'publish');

        // Filter berdasarkan tanggal mulai
        if ($request->has('start_date') && $request->start_date != '') {
            $query->where('start_date', '>=', $request->start_date);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $paketWisata = $query->orderBy('created_at', 'desc')->get();

        return view('member.page.paket-wisata.index', compact('paketWisata'));
    }

    public function detailPaketWisata($id)
    {
        $paket = PaketWisata::findOrFail($id);

        // Ambil paket wisata lain yang serupa (excluding current)
        $paketLainnya = PaketWisata::where('id', '!=', $id)
            ->where('status', 'publish')
            ->take(3)
            ->get();

        return view('member.page.paket-wisata.detail', compact('paket', 'paketLainnya'));
    }

    // Fungsi untuk halaman index berita
    public function berita(Request $request)
    {
        $query = Berita::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $berita = $query->orderBy('created_at', 'desc')->get();

        return view('member.page.berita.index', compact('berita'));
    }

    // Fungsi untuk detail berita
    public function detailBerita($id)
    {
        $berita = Berita::findOrFail($id);

        // Ambil berita lain (excluding current)
        $beritaLainnya = Berita::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('member.page.berita.detail', compact('berita', 'beritaLainnya'));
    }
    // Fungsi untuk halaman index video
    public function video(Request $request)
    {
        $query = Video::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $videos = $query->orderBy('created_at', 'desc')->get();

        return view('member.page.video.index', compact('videos'));
    }

    // Fungsi untuk detail video
    public function detailVideo($id)
    {
        $video = Video::findOrFail($id);

        // Ambil video lain (excluding current)
        $videoLainnya = Video::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('member.page.video.detail', compact('video', 'videoLainnya'));
    }

    // Fungsi untuk halaman index gallery
    public function gallery(Request $request)
    {
        $query = Gallery::query();

        // Filter berdasarkan pencarian caption
        if ($request->has('search') && $request->search != '') {
            $query->where('caption', 'like', '%' . $request->search . '%');
        }

        $galleries = $query->orderBy('created_at', 'desc')->get();

        return view('member.page.galeri.index', compact('galleries'));
    }
}
