<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Exports\CustomOrderReportExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminLaporanCustomOrderController extends Controller
{
    public function index()
    {
        $title = 'Laporan Custom Order';
        return view('admin.laporancustomorder.index', compact('title'));
    }

    public function data(Request $request)
    {
        // Memulai query dengan relasi user
        $query = CustomOrder::with('user');

        // Menerapkan filter tanggal hanya jika inputnya ada
        // Mirip dengan LaporanPenjualanController
        if ($request->filled('start_date')) {
            // Gunakan whereDate untuk perbandingan tanggal yang lebih efisien
            $query->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', function (CustomOrder $customOrder) {
                return $customOrder->user->name ?? 'N/A';
            })
            ->addColumn('design_description', function (CustomOrder $customOrder) {
                return $customOrder->design_description ?? 'N/A';
            })
            ->addColumn('fabric_type', function (CustomOrder $customOrder) {
                return $customOrder->fabric_type ?? 'N/A';
            })
            ->addColumn('quantity_value', function (CustomOrder $customOrder) {
                return $customOrder->qty ?? 0;
            })
            ->addColumn('total_price_formatted', function (CustomOrder $customOrder) {
                return 'Rp ' . number_format($customOrder->total_price, 0, ',', '.');
            })
            ->addColumn('ongkir_formatted', function (CustomOrder $customOrder) {
                return 'Rp ' . number_format($customOrder->ongkir, 0, ',', '.');
            })
            ->addColumn('total_with_ongkir_formatted', function (CustomOrder $customOrder) {
                $totalWithOngkir = $customOrder->total_price + $customOrder->ongkir;
                return 'Rp ' . number_format($totalWithOngkir, 0, ',', '.');
            })
            ->addColumn('status_order', function (CustomOrder $customOrder) {
                return $customOrder->status;
            })
            ->addColumn('order_date_formatted', function (CustomOrder $customOrder) {
                // Pastikan order_date tidak null sebelum parsing
                return $customOrder->order_date ? Carbon::parse($customOrder->order_date)->format('d M Y H:i') : '-';
            })
            ->rawColumns(['total_price_formatted', 'ongkir_formatted', 'total_with_ongkir_formatted'])
            ->make(true);
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $fileName = 'laporan-customorder';

        if ($startDate && $endDate) {
            $fileName .= '-' . Carbon::parse($startDate)->format('Ymd') . '-' . Carbon::parse($endDate)->format('Ymd');
        } else if ($startDate) {
            $fileName .= '-dari-' . Carbon::parse($startDate)->format('Ymd');
        } else if ($endDate) {
            $fileName .= '-sampai-' . Carbon::parse($endDate)->format('Ymd');
        }
        
        $fileName .= '.xlsx';

        return Excel::download(new CustomOrderReportExport($startDate, $endDate), $fileName);
    }
}
