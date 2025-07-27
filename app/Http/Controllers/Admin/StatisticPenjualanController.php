<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CustomOrder; // Pastikan model CustomOrder sudah tersedia
use Carbon\Carbon;

class StatisticPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal filter dari request atau gunakan default (bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
    
        // Query untuk order biasa
        $filteredOrders = Order::where('status', 'success')
            ->whereBetween('updated_at', [$startDate, $endDate]);
    
        // Query untuk custom order
        $filteredCustomOrders = CustomOrder::where('status', 'success')
            ->whereBetween('updated_at', [$startDate, $endDate]);
    
        // Hitung total pendapatan dan transaksi dengan menjumlahkan keduanya
        $totalRevenue = $filteredOrders->sum('amount') + $filteredCustomOrders->sum('remaining_payment');
        $totalTransactions = $filteredOrders->count() + $filteredCustomOrders->count();
    
        // Ambil data pendapatan per tanggal dari order biasa
        $dailyRevenueOrders = $filteredOrders
            ->selectRaw('DATE(updated_at) as date, SUM(amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        // Ambil data pendapatan per tanggal dari custom order
        $dailyRevenueCustomOrders = $filteredCustomOrders
            ->selectRaw('DATE(updated_at) as date, SUM(remaining_payment) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        // Gabungkan data pendapatan dari kedua sumber berdasarkan tanggal
        $mergedRevenue = [];
    
        // Masukkan data order biasa
        foreach ($dailyRevenueOrders as $data) {
            $date = $data->date;
            $mergedRevenue[$date] = $data->revenue;
        }
    
        // Gabungkan data custom order (jika tanggal sudah ada, jumlahkan nilainya)
        foreach ($dailyRevenueCustomOrders as $data) {
            $date = $data->date;
            if (isset($mergedRevenue[$date])) {
                $mergedRevenue[$date] += $data->revenue;
            } else {
                $mergedRevenue[$date] = $data->revenue;
            }
        }
    
        // Urutkan berdasarkan tanggal
        ksort($mergedRevenue);
    
        // Siapkan data untuk grafik
        $dates = [];
        $revenues = [];
        foreach ($mergedRevenue as $date => $revenue) {
            $dates[]    = Carbon::parse($date)->format('d M'); // Contoh: "10 Jan"
            $revenues[] = $revenue;
        }
    
        return view('admin.statistik.index', [
            'title'              => 'Statistic Pendapatan',
            'dates'              => $dates,
            'revenues'           => $revenues,
            'totalRevenue'       => $totalRevenue,
            'totalTransactions'  => $totalTransactions,
            'startDate'          => $startDate,
            'endDate'            => $endDate,
        ]);
    }
}
