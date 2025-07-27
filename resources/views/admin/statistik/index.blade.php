@extends('layouts.stisla')

@section('title', 'Statistic Pendapatan')

@section('content')

    <!-- Filter Tanggal -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" id="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-3">
            <label for="end_date">Tanggal Akhir</label>
            <input type="date" id="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button id="filter" class="btn btn-primary">Filter</button>
            <button id="reset" class="btn btn-secondary ml-2">Reset</button>
        </div>
    </div>

    <!-- Total Pendapatan dan Jumlah Transaksi -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
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
        <div class="col-md-6">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah Transaksi</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalTransactions }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendapatan -->
    <div class="card">
        <div class="card-header">
            <h4>Grafik Pendapatan</h4>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('filter').addEventListener('click', function() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            window.location.href = `?start_date=${startDate}&end_date=${endDate}`;
        });

        document.getElementById('reset').addEventListener('click', function() {
            window.location.href = `?`;
        });

        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!}, // Label berdasarkan tanggal transaksi
                datasets: [{
                    label: 'Pendapatan Harian (Rp)',
                    data: {!! json_encode($revenues) !!}, // Data pendapatan
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>

@endsection
