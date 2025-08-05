<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $title = 'My Order';
        $orders = Order::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        return view('frontend.user.order.index', compact('orders', 'title'));
    }

    public function orderDetail($orderId)
    {
        $title = 'My Order';
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->orderBy('id', 'DESC')->first();
        $orderItem = OrderItem::with('product')->where('order_id', $orderId)->orderBy('id', 'DESC')->get();

        return view('frontend.user.order.detail', compact('order', 'orderItem', 'title'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->orderBy('id', 'DESC')->first();
        $orderItem = OrderItem::with('product')->where('order_id', $id)->orderBy('id', 'DESC')->get();
        // return view('frontend.user.invoice.pdf', compact('order', 'orderItem'));

        $pdf = Pdf::loadView('frontend.user.invoice.pdf', compact('order', 'orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
            'isRemoteEnabled' => true
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function downloadInvoiceCustomOrder($id)
    {
        $customOrder = CustomOrder::where('id', $id)->where('user_id', Auth::id())->orderBy('id', 'DESC')->first();

        // Menentukan format tanggal dan jam untuk nama file
        $currentDateTime = Carbon::now()->format('dmY_His');

        // Membuat nama file dengan menambahkan tanggal dan waktu
        $fileName = 'invoice_custom_order_' . $currentDateTime . '.pdf';

        // Membuat PDF dan mengunduh dengan nama file yang dinamis
        $pdf = Pdf::loadView('admin.customorder.download', compact('customOrder'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
            'isRemoteEnabled' => true
        ]);

        return $pdf->download($fileName);
    }

    public function requestRefund(Request $request, $id)
{
    // Validasi input dari form, termasuk data rekening
    $request->validate([
        'refund_reason' => 'required|string|max:1000',
        'refund_bank_name' => 'required|string|max:50',
        'refund_account_name' => 'required|string|max:100',
        'refund_account_number' => 'required|string|max:50',
    ]);

    $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    if ($order->status != 'Success' || !is_null($order->refund_status)) {
        $notification = ['message' => 'Pesanan ini tidak dapat di-refund.','alert-type' => 'error'];
        return redirect()->back()->with($notification);
    }

    // Update status dan simpan data rekening ke database
    $order->update([
        'refund_status' => 'requested',
        'refund_reason' => $request->refund_reason,
        'refund_bank_name' => $request->refund_bank_name,
        'refund_account_name' => $request->refund_account_name,
        'refund_account_number' => $request->refund_account_number,
    ]);

    $notification = ['message' => 'Permintaan refund berhasil dikirim.','alert-type' => 'success'];
    return redirect()->back()->with($notification);
}
}
