<?php

namespace App\Exports;

use App\Models\Pesan;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemesananExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    private $no = 1;
    private $dateFrom;
    private $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection()
    {
        try {
            // Build query with filters
            $query = Pesan::with(['member', 'paketwisata'])
                ->orderBy('created_at', 'desc');

            // Apply date filter if provided
            if ($this->dateFrom && $this->dateTo) {
                $query->whereBetween('created_at', [
                    $this->dateFrom . ' 00:00:00',
                    $this->dateTo . ' 23:59:59'
                ]);
            }

            return $query->get();
        } catch (\Exception $e) {
            Log::error('Error fetching data for export: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return collect([]); // Return empty collection if error
        }
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Nama Member',
            'Email Member',
            'Paket Wisata',
            'Jumlah Orang',
            'Total Harga',
            'Status',
            'Bukti Bayar',
            'Tanggal Pesan',
        ];

        // Add period information if date filter is applied
        if ($this->dateFrom && $this->dateTo) {
            $periodInfo = 'Periode: ' . date('d/m/Y', strtotime($this->dateFrom)) . ' - ' . date('d/m/Y', strtotime($this->dateTo));
            // We'll add this as a separate row, but for now just return the normal headings
        }

        return $headings;
    }

    public function map($pemesanan): array
    {
        try {
            // Pastikan object tidak null sebelum mengakses properties
            if (!$pemesanan) {
                return [
                    $this->no++,
                    'Data tidak valid',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                ];
            }

            return [
                $this->no++,
                optional($pemesanan->member)->name ?? 'Member tidak ditemukan',
                optional($pemesanan->member)->email ?? '-',
                optional($pemesanan->paketwisata)->title ?? 'Paket tidak ditemukan',
                ($pemesanan->jumlah_orang ?? 0) . ' orang',
                'Rp. ' . number_format($pemesanan->total_harga ?? 0, 0, ',', '.'),
                ucfirst($pemesanan->status ?? 'unknown'),
                !empty($pemesanan->bukti_bayar) ? 'Ada' : 'Belum ada',
                $pemesanan->created_at ? $pemesanan->created_at->format('d/m/Y H:i') : '-',
            ];
        } catch (\Exception $e) {
            Log::error('Error mapping data: ' . $e->getMessage());
            Log::error('Data: ' . json_encode($pemesanan));
            return [
                $this->no++,
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
            ];
        }
    }

    public function styles(Worksheet $sheet)
    {
        try {
            // Add period information if date filter is applied
            if ($this->dateFrom && $this->dateTo) {
                $periodInfo = 'Periode: ' . date('d/m/Y', strtotime($this->dateFrom)) . ' - ' . date('d/m/Y', strtotime($this->dateTo));
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', $periodInfo);
                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E2EFDA',
                        ],
                    ],
                ]);

                // Add summary row
                $collection = $this->collection();
                $totalRevenue = $collection->whereIn('status', ['diverifikasi', 'selesai'])->sum('total_harga');
                $totalOrders = $collection->whereIn('status', ['diverifikasi', 'selesai'])->count();

                $sheet->insertNewRowBefore(2, 1);
                $summaryText = "Total Pendapatan: Rp. " . number_format($totalRevenue, 0, ',', '.') . " | Total Pesanan Lunas: " . $totalOrders;
                $sheet->setCellValue('A2', $summaryText);
                $sheet->mergeCells('A2:I2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFF2CC',
                        ],
                    ],
                ]);

                // Add empty row
                $sheet->insertNewRowBefore(3, 1);

                // Header now at row 4
                $headerRow = 4;
            } else {
                $headerRow = 1;
            }

            // Simplify styles to prevent conflicts
            $styles = [
                // Style untuk header
                $headerRow => [
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '4472C4',
                        ],
                    ],
                ],
            ];

            // Apply borders to all data rows
            $rowCount = $this->collection()->count() + $headerRow; // +header row
            for ($i = $headerRow; $i <= $rowCount; $i++) {
                $styles[$i]['borders'] = [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ];
            }

            return $styles;
        } catch (\Exception $e) {
            Log::error('Error applying styles: ' . $e->getMessage());
            return [];
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Nama Member
            'C' => 25,  // Email
            'D' => 25,  // Paket Wisata
            'E' => 12,  // Jumlah Orang
            'F' => 18,  // Total Harga
            'G' => 15,  // Status
            'H' => 12,  // Bukti Bayar
            'I' => 18,  // Tanggal Pesan
        ];
    }
}
