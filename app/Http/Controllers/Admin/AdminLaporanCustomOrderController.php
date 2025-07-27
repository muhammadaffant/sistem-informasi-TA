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
        $query = CustomOrder::with('user');

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', function (CustomOrder $customOrder) {
                return $customOrder->user->name ?? 'N/A';
            })
            // Mengembalikan nilai dari kolom 'design_description'
            ->addColumn('design_description', function (CustomOrder $customOrder) {
                return $customOrder->design_description ?? 'N/A';
            })
            // BARU: Menambahkan kolom untuk Tipe Kain
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
                return Carbon::parse($customOrder->order_date)->format('d M Y H:i');
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
            $fileName .= '-' . Carbon::parse($startDate)->format('Ymd');
        } else if ($endDate) {
            $fileName .= '-' . Carbon::parse($endDate)->format('Ymd');
        }
        $fileName .= '.xlsx';

        return Excel::download(new CustomOrderReportExport($startDate, $endDate), $fileName);
    }
}