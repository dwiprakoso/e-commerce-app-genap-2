@extends('admin.layouts.app')
@section('content')
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Pemesanan</h1>
            <p class="mb-4">Kelola data pemesanan paket wisata dari member.</p>

            <!-- Revenue Report Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Pendapatan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Export Laporan:</div>
                            <a class="dropdown-item"
                                href="{{ route('admin.pemesanan.export.excel') }}?date_from={{ $revenueData['date_from'] }}&date_to={{ $revenueData['date_to'] }}">
                                <i class="fas fa-file-excel fa-sm fa-fw mr-2 text-gray-400"></i>
                                Export Excel
                            </a>
                            <a class="dropdown-item"
                                href="{{ route('admin.pemesanan.export.pdf') }}?date_from={{ $revenueData['date_from'] }}&date_to={{ $revenueData['date_to'] }}">
                                <i class="fas fa-file-pdf fa-sm fa-fw mr-2 text-gray-400"></i>
                                Export PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.pemesanan.index') }}" class="mb-4" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="period">Periode:</label>
                                <select name="period" id="period" class="form-control" onchange="handlePeriodChange()">
                                    <option value="all" {{ $revenueData['period'] == 'all' ? 'selected' : '' }}>Semua
                                        Waktu</option>
                                    <option value="week" {{ $revenueData['period'] == 'week' ? 'selected' : '' }}>Minggu
                                        Ini</option>
                                    <option value="month" {{ $revenueData['period'] == 'month' ? 'selected' : '' }}>Bulan
                                        Ini</option>
                                    <option value="year" {{ $revenueData['period'] == 'year' ? 'selected' : '' }}>Tahun
                                        Ini</option>
                                    <option value="custom" {{ $revenueData['period'] == 'custom' ? 'selected' : '' }}>
                                        Custom</option>
                                </select>
                            </div>
                            <div class="col-md-3" id="dateFromDiv"
                                style="display: {{ $revenueData['period'] == 'custom' ? 'block' : 'none' }};">
                                <label for="date_from">Dari Tanggal:</label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                    value="{{ $revenueData['period'] == 'custom' ? $revenueData['date_from'] : '' }}">
                            </div>
                            <div class="col-md-3" id="dateToDiv"
                                style="display: {{ $revenueData['period'] == 'custom' ? 'block' : 'none' }};">
                                <label for="date_to">Sampai Tanggal:</label>
                                <input type="date" name="date_to" id="date_to" class="form-control"
                                    value="{{ $revenueData['period'] == 'custom' ? $revenueData['date_to'] : '' }}">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Revenue Stats -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Pendapatan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Rp {{ number_format($revenueData['total_revenue'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Pesanan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($revenueData['total_orders']) }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Rata-rata Pesanan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Rp {{ number_format($revenueData['average_order'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Periode
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                @if ($revenueData['date_from'] && $revenueData['date_to'])
                                                    {{ date('d/m/Y', strtotime($revenueData['date_from'])) }} -
                                                    {{ date('d/m/Y', strtotime($revenueData['date_to'])) }}
                                                @else
                                                    Semua Waktu
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Filter Cards -->
            <div class="row mb-4">
                <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pemesanans->total() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $pemesanans->where('status', 'pending')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card shadow mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <!-- Alternative Export Buttons - Menggunakan parameter filter eksplisit -->
                        <a href="{{ route('admin.pemesanan.export.excel') }}?period={{ $revenueData['period'] }}&date_from={{ $revenueData['date_from'] }}&date_to={{ $revenueData['date_to'] }}"
                            class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.pemesanan.export.pdf') }}?period={{ $revenueData['period'] }}&date_from={{ $revenueData['date_from'] }}&date_to={{ $revenueData['date_to'] }}"
                            class="btn btn-danger ml-2">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Table content tetap sama -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <!-- Table headers dan content tetap sama -->
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Member</th>
                                    <th>Paket Wisata</th>
                                    <th>Jumlah Orang</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Bukti Bayar</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pemesanans as $pemesanan)
                                    <tr>
                                        <td>{{ $loop->iteration + ($pemesanans->currentPage() - 1) * $pemesanans->perPage() }}
                                        </td>
                                        <td>
                                            @if ($pemesanan->member)
                                                {{ $pemesanan->member->name }}
                                            @else
                                                <span class="text-danger">Member tidak ditemukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pemesanan->paketwisata)
                                                {{ $pemesanan->paketwisata->title }}
                                            @else
                                                <span class="text-danger">Paket tidak ditemukan</span>
                                            @endif
                                        </td>
                                        <td>{{ $pemesanan->jumlah_orang }} orang</td>
                                        <td>Rp. {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge 
                                                @if ($pemesanan->status == 'pending') badge-warning
                                                @elseif($pemesanan->status == 'dibayar') badge-info
                                                @elseif($pemesanan->status == 'diverifikasi') badge-primary
                                                @elseif($pemesanan->status == 'selesai') badge-success
                                                @elseif($pemesanan->status == 'dibatalkan') badge-danger
                                                @else badge-secondary @endif">
                                                {{ ucfirst($pemesanan->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($pemesanan->bukti_bayar)
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#buktiBayarModal{{ $pemesanan->id }}">
                                                    <i class="fas fa-eye"></i> Lihat Bukti
                                                </button>
                                            @else
                                                <span class="text-muted">Belum ada bukti</span>
                                            @endif
                                        </td>
                                        <td>{{ $pemesanan->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.pemesanan.edit', $pemesanan->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit Status">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Tidak ada data pemesanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($pemesanans->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pemesanans->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modals for Bukti Bayar -->
        @foreach ($pemesanans as $pemesanan)
            @if ($pemesanan->bukti_bayar)
                <!-- Modal Bukti Bayar -->
                <div class="modal fade" id="buktiBayarModal{{ $pemesanan->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="buktiBayarModalLabel{{ $pemesanan->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buktiBayarModalLabel{{ $pemesanan->id }}">
                                    Bukti Pembayaran -
                                    @if ($pemesanan->member)
                                        {{ $pemesanan->member->name }}
                                    @else
                                        Member tidak ditemukan
                                    @endif
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                @if (file_exists(storage_path('app/public/' . $pemesanan->bukti_bayar)))
                                    <img src="{{ asset('storage/' . $pemesanan->bukti_bayar) }}" class="img-fluid"
                                        alt="Bukti Pembayaran" style="max-height: 500px;"
                                        onerror="this.src='{{ asset('img/no-image.png') }}';">
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        File bukti pembayaran tidak ditemukan
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <div class="mr-auto">
                                    <small class="text-muted">
                                        <strong>Paket:</strong>
                                        @if ($pemesanan->paketwisata)
                                            {{ $pemesanan->paketwisata->title }}
                                        @else
                                            Paket tidak ditemukan
                                        @endif
                                        <br>
                                        <strong>Total:</strong> Rp.
                                        {{ number_format($pemesanan->total_harga, 0, ',', '.') }}<br>
                                        <strong>Tanggal:</strong> {{ $pemesanan->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <!-- /.container-fluid -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#dataTable').DataTable({
                "paging": false,
                "searching": false,
                "info": false,
                "ordering": true,
                "order": [
                    [7, "desc"]
                ] // Sort by date column
            });
        });

        // Handle period change for custom date inputs
        function handlePeriodChange() {
            const period = document.getElementById('period').value;
            const dateFromDiv = document.getElementById('dateFromDiv');
            const dateToDiv = document.getElementById('dateToDiv');
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');

            if (period === 'custom') {
                // Show custom date inputs
                dateFromDiv.style.display = 'block';
                dateToDiv.style.display = 'block';
            } else {
                // Hide custom date inputs and clear their values
                dateFromDiv.style.display = 'none';
                dateToDiv.style.display = 'none';
                dateFromInput.value = '';
                dateToInput.value = '';
            }
        }

        // Auto submit when both dates are selected (for custom period only)
        function handleDateChange() {
            const period = document.getElementById('period').value;
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');

            // Only auto-submit if period is custom and both dates are filled
            if (period === 'custom' && dateFromInput.value && dateToInput.value) {
                // Add small delay to ensure both dates are properly set
                setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 100);
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            handlePeriodChange();

            // Add event listeners for date inputs
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');

            if (dateFromInput) {
                dateFromInput.addEventListener('change', handleDateChange);
            }

            if (dateToInput) {
                dateToInput.addEventListener('change', handleDateChange);
            }
        });

        // Chart.js for Monthly Revenue
        document.addEventListener('DOMContentLoaded', function() {
            const chartElement = document.getElementById('monthlyRevenueChart');
            if (chartElement) {
                const ctx = chartElement.getContext('2d');
                const monthlyData = @json($revenueData['monthly_revenue'] ?? []);

                if (monthlyData && monthlyData.length > 0) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: monthlyData.map(item => item.period),
                            datasets: [{
                                label: 'Pendapatan (Rp)',
                                data: monthlyData.map(item => item.total),
                                borderColor: 'rgb(75, 192, 192)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString(
                                                'id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
        });
    </script>
@endpush
