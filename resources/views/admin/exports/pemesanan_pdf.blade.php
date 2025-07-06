<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            color: #666;
            margin: 5px 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .info-item {
            display: inline-block;
            margin-right: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 9px;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-dibayar {
            background-color: #17a2b8;
        }

        .status-diverifikasi {
            background-color: #007bff;
        }

        .status-selesai {
            background-color: #28a745;
        }

        .status-dibatalkan {
            background-color: #dc3545;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA PEMESANAN</h1>
        <p>Paket Wisata</p>
    </div>

    <div class="info">
        <div class="info-item">
            <strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i') }}
        </div>
        <div class="info-item">
            <strong>Total Data:</strong> {{ $pemesanans->count() }} pemesanan
        </div>

        <!-- Tambahan info periode (opsional) -->
        @if (isset($revenueData['date_from']) &&
                isset($revenueData['date_to']) &&
                $revenueData['date_from'] &&
                $revenueData['date_to']
        )
            <div class="info-item">
                <strong>Periode:</strong> {{ date('d/m/Y', strtotime($revenueData['date_from'])) }} -
                {{ date('d/m/Y', strtotime($revenueData['date_to'])) }}
            </div>
        @endif

        @if (isset($revenueData['total_revenue']))
            <div class="info-item">
                <strong>Total Pendapatan:</strong> Rp. {{ number_format($revenueData['total_revenue'], 0, ',', '.') }}
            </div>
        @endif
    </div>

    @if ($pemesanans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nama Member</th>
                    <th width="20%">Paket Wisata</th>
                    <th width="8%">Jumlah</th>
                    <th width="15%">Total Harga</th>
                    <th width="10%">Status</th>
                    <th width="17%">Tanggal Pesan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanans as $index => $pemesanan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            @if ($pemesanan->member)
                                {{ $pemesanan->member->name }}
                                <br><small style="color: #666;">{{ $pemesanan->member->email }}</small>
                            @else
                                <span style="color: #dc3545;">Member tidak ditemukan</span>
                            @endif
                        </td>
                        <td>
                            @if ($pemesanan->paketwisata)
                                {{ $pemesanan->paketwisata->title }}
                            @else
                                <span style="color: #dc3545;">Paket tidak ditemukan</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $pemesanan->jumlah_orang }} orang</td>
                        <td class="text-right">Rp. {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="status-badge status-{{ $pemesanan->status }}">
                                {{ ucfirst($pemesanan->status) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $pemesanan->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <h4>Ringkasan Status:</h4>
            <table style="width: 300px; font-size: 11px;">
                <tr>
                    <td><strong>Total Pending:</strong></td>
                    <td class="text-right">{{ $pemesanans->where('status', 'pending')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Total Dibayar:</strong></td>
                    <td class="text-right">{{ $pemesanans->where('status', 'dibayar')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Total Diverifikasi:</strong></td>
                    <td class="text-right">{{ $pemesanans->where('status', 'diverifikasi')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Total Selesai:</strong></td>
                    <td class="text-right">{{ $pemesanans->where('status', 'selesai')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Total Dibatalkan:</strong></td>
                    <td class="text-right">{{ $pemesanans->where('status', 'dibatalkan')->count() }}</td>
                </tr>
                <tr style="border-top: 2px solid #333; font-weight: bold;">
                    <td><strong>TOTAL KESELURUHAN:</strong></td>
                    <td class="text-right">{{ $pemesanans->count() }}</td>
                </tr>
            </table>
        </div>
    @else
        <div class="no-data">
            <h3>Tidak ada data pemesanan</h3>
            <p>Belum ada pemesanan yang terdaftar dalam sistem</p>
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
