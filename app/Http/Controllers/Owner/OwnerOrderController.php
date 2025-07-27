<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OwnerOrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return view('owner.order.index',[
            'title' => 'Owner'
        ]);
    }

    public function data(Request $request)
    {
        $result = $this->orderService->getByOwner($request);

        return DataTables::of($result)
            ->addIndexColumn()
            ->editColumn('order_date', function ($q) {
                return \Carbon\Carbon::parse($q->order_date)->format('d M Y');
            })
            ->editColumn('status', fn($q) => $this->renderStatusColumns($q))
            ->escapeColumns([])
            ->make(true);
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
