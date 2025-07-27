<?php

namespace App\Http\Controllers;

// Pastikan semua model dan facade yang dibutuhkan sudah di-import
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\ProdukTerlarisExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $title = $user->hasRole('admin') || $user->hasRole('owner') 
            ? 'Dashboard' 
            : 'UserDashboard';
    
        if ($user->hasRole('admin') || $user->hasRole('owner')) {
            $orderSuccess = Order::where('status', 'Success')->count();
            $orderPending = Order::where('status', 'Pending')->count();
            $totalUser      = User::role('user')->count();
            $totalProduct = Product::where('status', 1)->where('product_qty', '>=', 0)->count();
            $totalRevenue = Order::where('status', 'success')->sum('amount') 
                + CustomOrder::where('status', 'success')->sum('remaining_payment');

            // Transaksi sukses per bulan (kode Anda yang sudah ada)
            // Menggabungkan data dari Order dan CustomOrder
            $monthlySuccessOrders = Order::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
                ->where('status', 'Success')
                ->groupByRaw('MONTH(updated_at)');

            $monthlySuccessCustomOrders = CustomOrder::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
                ->where('status', 'Success')
                ->groupByRaw('MONTH(updated_at)');

            $combinedMonthlySuccess = DB::query()
                ->selectRaw('month, SUM(total) as total')
                ->fromSub($monthlySuccessOrders->unionAll($monthlySuccessCustomOrders), 'sub')
                ->groupBy('month')
                ->pluck('total', 'month');

            $months = [];
            $successCounts = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[] = Carbon::create()->month($i)->format('F');
                $successCounts[] = $combinedMonthlySuccess[$i] ?? 0;
            }

            // --- LOGIKA PRODUK TERLARIS ---
            $year = 2025;
            $topProducts = OrderItem::query()
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereYear('orders.created_at', $year) 
                ->select(
                    'products.product_name',
                    DB::raw('SUM(order_items.qty) as total_terjual')
                )
                ->groupBy('products.product_name')
                ->orderBy('total_terjual', 'desc')
                ->limit(10)
                ->get();

            // Siapkan data untuk dikirim ke view
            $productNames = $topProducts->pluck('product_name');
            $productSales = $topProducts->pluck('total_terjual');
            // --- AKHIR LOGIKA PRODUK TERLARIS ---

            return view('admin.dashboard.index', compact(
                'title',
                'orderSuccess',
                'orderPending',
                'totalRevenue',
                'totalProduct',
                'totalUser',
                'months',
                'successCounts',
                'productNames',
                'productSales'
            ));
        } else {
            return view('user.dashboard', compact('title'));
        }
    }

    public function exportTopProducts()
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        $year = 2025;
        return Excel::download(new ProdukTerlarisExport($year), 'produk-terlaris-2025.xlsx');
    }
}