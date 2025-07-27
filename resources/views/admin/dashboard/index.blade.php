@extends('layouts.stisla')

@section('title', 'Dashboard')

@section('content')
    {{-- Baris untuk Card Statistik (Tidak ada perubahan) --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Order Success</h4>
                    </div>
                    <div class="card-body">
                        {{ $orderSuccess }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pendapatan</h4>
                    </div>
                    <div class="card-body">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Produk</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalProduct }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pelanggan</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalUser }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris untuk Grafik --}}
    <div class="row">
        {{-- Grafik Transaksi Bulanan (Kode Anda yang sudah ada) --}}
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Jumlah Transaksi Sukses per Bulan</h4>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart" height="120"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Produk Terlaris (Grafik Baru) --}}
        <div class="col-lg-5 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Produk Terlaris (2025)</h4>
                </div>
                <div class="card-body">
                    <canvas id="topProductsChart" height="120"></canvas>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button id="downloadChartBtn" class="btn btn-sm btn-primary">Unduh Grafik (PNG)</button>
                    <a href="{{ route('dashboard.export_top_products') }}" class="btn btn-sm btn-success ml-2">Unduh Data (Excel)</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
{{-- Load Chart.js sekali saja --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Pastikan script dijalankan setelah halaman selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        
        // =================================================
        // SCRIPT UNTUK GRAFIK TRANSAKSI (KODE ANDA)
        // =================================================
        const ctxTransaction = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(ctxTransaction, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Jumlah Transaksi Sukses',
                    data: @json($successCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Pastikan tidak ada desimal di sumbu Y
                        }
                    }
                }
            }
        });


        // =================================================
        // SCRIPT UNTUK GRAFIK PRODUK TERLARIS (BARU)
        // =================================================
 // Ganti keseluruhan script untuk grafik produk terlaris dengan ini
// =================================================
// SCRIPT UNTUK GRAFIK PRODUK TERLARIS (VERSI VERTIKAL)
// =================================================
const productLabels = @json($productNames);
const productData = @json($productSales);

const ctxTopProducts = document.getElementById('topProductsChart').getContext('2d');
const topProductsChart = new Chart(ctxTopProducts, {
    type: 'bar',
    data: {
        labels: productLabels,
        datasets: [{
            label: 'Total Unit Terjual',
            data: productData,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        // Hapus 'indexAxis: 'y'' untuk menjadikannya vertikal
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            // Konfigurasi untuk sumbu X (Nama Produk)
            x: {
                ticks: {
                    // Di sinilah kita memiringkan label
                    maxRotation: 70, // Derajat kemiringan maksimal
                    minRotation: 45, // Derajat kemiringan minimal
                    autoSkip: false, // Jangan lewati label apapun
                }
            },
            // Konfigurasi untuk sumbu Y (Jumlah Penjualan)
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

// Fungsi tombol download tidak perlu diubah
document.getElementById('downloadChartBtn').addEventListener('click', function() {
    const link = document.createElement('a');
    link.href = topProductsChart.toBase64Image('image/png', 1);
    link.download = 'grafik-produk-terlaris-2025.png';
    link.click();
});

    });
</script>
@endpush