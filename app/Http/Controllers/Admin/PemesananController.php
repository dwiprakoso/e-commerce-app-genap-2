<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PemesananExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $period = $request->input('period', 'all');

        // Set default dates berdasarkan period (hanya jika period bukan custom)
        if ($period !== 'custom') {
            switch ($period) {
                case 'week':
                    $dateFrom = now()->startOfWeek()->format('Y-m-d');
                    $dateTo = now()->endOfWeek()->format('Y-m-d');
                    break;
                case 'month':
                    $dateFrom = now()->startOfMonth()->format('Y-m-d');
                    $dateTo = now()->endOfMonth()->format('Y-m-d');
                    break;
                case 'year':
                    $dateFrom = now()->startOfYear()->format('Y-m-d');
                    $dateTo = now()->endOfYear()->format('Y-m-d');
                    break;
                default: // 'all'
                    $dateFrom = null;
                    $dateTo = null;
            }
        }

        // Query untuk data tabel pemesanan (dengan filter yang sama)
        $pemesanansQuery = Pesan::with(['member', 'paketwisata']);

        if ($dateFrom && $dateTo) {
            $pemesanansQuery->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ]);
        }

        $pemesanans = $pemesanansQuery->orderBy('created_at', 'desc')->paginate(10);

        // Query untuk laporan pendapatan
        $revenueQuery = Pesan::whereIn('status', ['diverifikasi', 'selesai']);

        if ($dateFrom && $dateTo) {
            $revenueQuery->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ]);
        }

        // Data laporan pendapatan
        $totalRevenue = $revenueQuery->sum('total_harga');
        $totalOrders = $revenueQuery->count();
        $averageOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Pendapatan per bulan (untuk chart)
        $monthlyRevenue = Pesan::whereIn('status', ['diverifikasi', 'selesai'])
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_harga) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($item) {
                return [
                    'period' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'total' => $item->total
                ];
            });

        // Top 5 paket wisata terlaris
        $topPackages = Pesan::with('paketwisata')
            ->whereIn('status', ['diverifikasi', 'selesai'])
            ->selectRaw('paketwisata_id, COUNT(*) as order_count, SUM(total_harga) as total_revenue')
            ->groupBy('paketwisata_id')
            ->orderBy('order_count', 'desc')
            ->limit(5)
            ->get();

        // Data untuk view
        $revenueData = [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'average_order' => $averageOrder,
            'monthly_revenue' => $monthlyRevenue,
            'top_packages' => $topPackages,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'period' => $period
        ];

        return view('admin.page.pemesanan.index', compact('pemesanans', 'revenueData'));
    }


    public function exportExcel(Request $request)
    {
        try {
            // Increase memory limit and execution time
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', 300);

            // Get filter parameters
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');
            $period = $request->input('period', 'all');

            // Set default dates berdasarkan period (sama seperti di index)
            if ($period !== 'custom') {
                switch ($period) {
                    case 'week':
                        $dateFrom = now()->startOfWeek()->format('Y-m-d');
                        $dateTo = now()->endOfWeek()->format('Y-m-d');
                        break;
                    case 'month':
                        $dateFrom = now()->startOfMonth()->format('Y-m-d');
                        $dateTo = now()->endOfMonth()->format('Y-m-d');
                        break;
                    case 'year':
                        $dateFrom = now()->startOfYear()->format('Y-m-d');
                        $dateTo = now()->endOfYear()->format('Y-m-d');
                        break;
                    default: // 'all'
                        $dateFrom = null;
                        $dateTo = null;
                }
            }

            // Build query with filters
            $query = Pesan::with(['member', 'paketwisata']);

            if ($dateFrom && $dateTo) {
                $query->whereBetween('created_at', [
                    $dateFrom . ' 00:00:00',
                    $dateTo . ' 23:59:59'
                ]);
            }

            // Check if data exists
            $count = $query->count();
            if ($count == 0) {
                return redirect()->back()->with('warning', 'Tidak ada data untuk diexport');
            }

            Log::info('Starting Excel export with ' . $count . ' records');

            // Create filename with date range
            $fileName = 'pemesanan_';
            if ($dateFrom && $dateTo) {
                $fileName .= date('Y-m-d', strtotime($dateFrom)) . '_to_' . date('Y-m-d', strtotime($dateTo));
            } else {
                $fileName .= date('Y-m-d_H-i-s');
            }
            $fileName .= '.xlsx';

            Log::info('Excel export starting for file: ' . $fileName);

            // Pass filters to export class
            return Excel::download(new PemesananExport($dateFrom, $dateTo, $period), $fileName);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::error('Excel Validation Error: ' . json_encode($e->failures()));
            return redirect()->back()->with('error', 'Validasi Excel gagal: ' . implode(', ', $e->failures()));
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            Log::error('PhpSpreadsheet Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error PhpSpreadsheet: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Excel Export Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengexport Excel: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            // Get filter parameters
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');
            $period = $request->input('period', 'all');

            // Set default dates berdasarkan period (sama seperti di index)
            if ($period !== 'custom') {
                switch ($period) {
                    case 'week':
                        $dateFrom = now()->startOfWeek()->format('Y-m-d');
                        $dateTo = now()->endOfWeek()->format('Y-m-d');
                        break;
                    case 'month':
                        $dateFrom = now()->startOfMonth()->format('Y-m-d');
                        $dateTo = now()->endOfMonth()->format('Y-m-d');
                        break;
                    case 'year':
                        $dateFrom = now()->startOfYear()->format('Y-m-d');
                        $dateTo = now()->endOfYear()->format('Y-m-d');
                        break;
                    default: // 'all'
                        $dateFrom = null;
                        $dateTo = null;
                }
            }

            // Build query with filters
            $query = Pesan::with(['member', 'paketwisata']);

            if ($dateFrom && $dateTo) {
                $query->whereBetween('created_at', [
                    $dateFrom . ' 00:00:00',
                    $dateTo . ' 23:59:59'
                ]);
            }

            $pemesanans = $query->orderBy('created_at', 'desc')->get();

            // Check if data exists
            if ($pemesanans->isEmpty()) {
                return redirect()->back()->with('warning', 'Tidak ada data untuk diexport');
            }

            // Calculate revenue data for PDF
            $revenueData = [
                'total_revenue' => $pemesanans->whereIn('status', ['diverifikasi', 'selesai'])->sum('total_harga'),
                'total_orders' => $pemesanans->whereIn('status', ['diverifikasi', 'selesai'])->count(),
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'period' => $period
            ];

            $pdf = Pdf::loadView('admin.exports.pemesanan_pdf', compact('pemesanans', 'revenueData'));
            $pdf->setPaper('A4', 'landscape');

            // Create filename with date range
            $fileName = 'pemesanan_';
            if ($dateFrom && $dateTo) {
                $fileName .= date('Y-m-d', strtotime($dateFrom)) . '_to_' . date('Y-m-d', strtotime($dateTo));
            } else {
                $fileName .= date('Y-m-d_H-i-s');
            }
            $fileName .= '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengexport PDF: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pemesanan = Pesan::with(['member', 'paketwisata'])->findOrFail($id);
        return view('admin.page.pemesanan.edit', compact('pemesanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,dibayar,diverifikasi,selesai,dibatalkan'
        ]);

        $pemesanan = Pesan::findOrFail($id);
        $pemesanan->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.pemesanan.index')
            ->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}
