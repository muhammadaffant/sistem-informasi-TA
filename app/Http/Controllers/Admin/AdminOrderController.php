<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Order\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.order.index',[
            'title' => 'Order'
        ]);
    }

    // public function data()
    // {   
    //     $result = $this->orderService->getData();

    //     return datatables($result)
    //         ->addIndexColumn()
    //         ->editColumn('status', fn($q) => $this->renderStatusColumns($q))
    //         ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
    //         ->escapeColumns([])
    //         ->make(true);
    // }

    public function data()
{
    $result = $this->orderService->getData();

    $orders = Order::with('orderItems.product', 'province', 'regency', 'district', 'village') // Eager load OrderItems and Product
        ->success()
        ->get();

    return datatables($orders)
        ->addIndexColumn()
        ->addColumn('created_at', function($order) {
            // Jika kosong, tampilkan '-'
            if (!$order->created_at) return '-';

            // Coba parsing dan format ke tanggal Indonesia
            try {
                return Carbon::parse($order->created_at)->format('d-m-Y');
            } catch (\Exception $e) {
                return $order->created_at; // fallback jika format tidak bisa diparse
            }
        })

        ->addColumn('alamat_lengkap', function ($order) {
            return implode(', ', array_filter([
                $order->address,
                // optional($order->village)->name ?? 'Desa ID: ' . $order->village_id,
                // optional($order->district)->name ?? 'Kec. ID: ' . $order->district_id,
                // optional($order->regency)->name ?? 'Kab/Kota ID: ' . $order->regency_id,
                // optional($order->province)->name ?? 'Prov. ID: ' . $order->province_id,
            ]));
        })



        ->addColumn('post_code', function($order) {
            return $order->post_code ?? '-';
        })


        ->editColumn('status', fn($q) => $this->renderStatusColumns($q))
        ->addColumn('status_pesanan', function($q) {
               // Jika ada permintaan refund, tampilkan detail rekening bank
            if ($q->refund_status == 'requested') {
                $html = '<span class="badge badge-warning">Menunggu Persetujuan Refund</span>';
                $html .= '<div class="mt-2" style="font-size: 12px; text-align: left; white-space: normal;">';
                $html .= '<strong>Bank:</strong> ' . e($q->refund_bank_name) . '<br>';
                $html .= '<strong>A/N:</strong> ' . e($q->refund_account_name) . '<br>';
                $html .= '<strong>No. Rek:</strong> ' . e($q->refund_account_number) . '<br>';
                $html .= '<strong>Alasan:</strong> ' . e($q->refund_reason);
                $html .= '</div>';
                return $html;
            }
            if ($q->refund_status == 'refunded') {
                return '<span class="badge badge-danger">Dana Dikembalikan</span>';
            }
            
            // ================== PERUBAHAN DI SINI ==================
            // Logika untuk menampilkan dropdown status pesanan
            $selectedProcessing = $q->status_pesanan == "proses" ? "selected" : "";
            $selectedShipped = $q->status_pesanan == "dikirim" ? "selected" : "";
            $selectedCompleted = $q->status_pesanan == "selesai" ? "selected" : "";
            $noStatusSelected = is_null($q->status_pesanan) ? 'selected' : '';

            $dropdownHTML = '
                <select class="form-control status-pesanan mt-2" data-id="'. $q->id .'">
                    <option value="" disabled '. $noStatusSelected .'>Pilih Status</option>
                    <option value="proses" '. $selectedProcessing .'>Proses</option>
                    <option value="dikirim" '. $selectedShipped .'>Dikirim</option>
                    <option value="selesai" '. $selectedCompleted .'>Selesai</option>
                </select>
            ';

            // Jika refund ditolak, tampilkan badge DAN dropdown
            if ($q->refund_status == 'rejected') {
                return '<span class="badge badge-secondary">Refund Ditolak</span>' . $dropdownHTML;
            }
            
            // Jika tidak ada urusan refund, tampilkan dropdown saja
            return $dropdownHTML;
            })
        ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
        ->addColumn('product_name', function($order) {
            return $order->orderItems->map(function($item) {
                return $item->product->product_name;
            })->implode(', ');
        })
        ->addColumn('product_code', function($order) {
            return $order->orderItems->map(function($item) {
                return $item->product->product_code;
            })->implode(', ');
        })
        ->addColumn('size', function($order) {
            return $order->orderItems->map(fn($item) => $item->size)->implode(', ');
        })
        // ->addColumn('jumlah', function($order) {
        //     return $order->orderItems->map(fn($item) => $item->qty)->sum();
        // })
        ->addColumn('harga', function($order) {
            return 'Rp. ' . format_uang($order->orderItems->sum(function($item) {
                return $item->price * $item->qty;
            }));
        })
        ->addColumn('ongkir', function($order) {
            return 'Rp. ' . format_uang($order->ongkir);
        })

        ->addColumn('courir', function($order) {
            return $order->courir ?? '-';
        })
        ->escapeColumns([])
        ->make(true);
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = $this->orderService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->orderService->update($request->all(), $id);

        if ($result['status'] === 'success') {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors'  => $result['errors'],
            'message' => $result['message'],
        ], 422);
    }

    public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|exists:orders,id',
        'status_pesanan' => 'required|in:proses,dikirim,selesai',
    ]);

    $order = Order::findOrFail($request->id);
    $order->status_pesanan = $request->status_pesanan;
    $order->save();

    return response()->json([
        'status' => 200,
        'message' => 'Status pesanan berhasil diperbarui!'
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->orderService->destroy($id);

        return response()->json([
            'message' => $result['message'],
        ]);
    }

    public function download($id)
    {
        $result  = $this->orderService->download($id);
        $order = $result['order'];
        $orderItem = $result['orderItems'];

        // Menentukan format tanggal dan jam untuk nama file
        $currentDateTime = Carbon::now()->format('dmY_His');

        // Membuat nama file dengan menambahkan tanggal dan waktu
        $fileName = 'invoice_' . $currentDateTime . '.pdf';

        // Membuat PDF dan mengunduh dengan nama file yang dinamis
        $pdf = Pdf::loadView('admin.order.download', compact('order', 'orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
            'isRemoteEnabled' => true
        ]);

        return $pdf->download($fileName);
    }

    /**
     * Render aksi buttons
     */
   protected function renderActionButtons($q)
{
    if ($q->refund_status === 'requested') {
        // Tombol untuk menandai SUDAH transfer manual
        $approveForm = '
            <form action="'. route('admin.orders.refund.manual_process') .'" method="POST" class="d-inline" onsubmit="return confirm(\'PASTIKAN ANDA SUDAH TRANSFER DANA. Lanjutkan?\')">
                '. csrf_field() .'
                <input type="hidden" name="order_id" value="'. $q->id .'">
                <input type="hidden" name="action" value="approve">
                <button type="submit" class="btn btn-success btn-sm" title="Tandai Sudah Direfund"><i class="fas fa-check"></i></button>
            </form>';

        // Tombol untuk menolak
        $rejectForm = '
            <form action="'. route('admin.orders.refund.manual_process') .'" method="POST" class="d-inline" onsubmit="return confirm(\'Anda yakin ingin MENOLAK refund ini?\')">
                '. csrf_field() .'
                <input type="hidden" name="order_id" value="'. $q->id .'">
                <input type="hidden" name="action" value="reject">
                <button type="submit" class="btn btn-danger btn-sm" title="Tolak Refund"><i class="fas fa-times"></i></button>
            </form>';

        return $approveForm . ' ' . $rejectForm;
    }
    
    return '<a href="' . route('admin.orders.download', $q->id) . '" class="btn btn-xs btn-primary mr-1" title="Download Invoice"><i class="fa fa-download"></i></a>';
}

public function manualProcessRefund(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'action' => 'required|in:approve,reject',
    ]);

    $order = Order::findOrFail($request->order_id);
    
    if ($order->refund_status !== 'requested') {
        return back()->with('error', 'Status refund pesanan ini sudah tidak valid.');
    }

    if ($request->action === 'approve') {
        // Hanya update database, TIDAK ADA API CALL
        $order->update([
            'status'         => 'Refunded',
            'status_pesanan' => 'dibatalkan',
            'refund_status'  => 'refunded',
        ]);
        return back()->with('success', 'Pesanan telah ditandai sebagai direfund.');
    }
    
    if ($request->action === 'reject') {
        $order->update(['refund_status' => 'rejected']);
        return back()->with('success', 'Permintaan refund telah ditolak.');
    }
}

    protected function renderStatusColumns($q)
    {
        $color = '';

        switch ($q->status) {
            case 'Pending':
                $color = 'warning';
                break;

            case 'Success':
                $color = 'success';
                break;

            case 'Canceled':
                $color = 'danger';
                break;

            default:
                # code...
                break;
        }

        return '<span class="badge badge-' . $color . '">' . $q->status . '</span>';
    }

    protected function renderInvoiceNoColumns($q)
    {
        return '<span class="badge badge-info"> ' . $q->invoice_no . '</span>';
    }
}
