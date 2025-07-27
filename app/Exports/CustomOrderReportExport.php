<?php

namespace App\Exports;

use App\Models\CustomOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class CustomOrderReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = CustomOrder::query()->with('user');

        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->startOfDay();
            $endDate = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        $customOrders = $query->get();

        // Map the collection to the desired format for export
        return $customOrders->map(function ($order) {
            $sizeDetails = json_decode($order->size, true);
            $sizeString = '';
            if (is_array($sizeDetails)) {
                foreach ($sizeDetails as $item) {
                    $sizeString .= $item['size'] . ' (' . $item['quantity'] . ' pcs), ';
                }
                $sizeString = rtrim($sizeString, ', '); // Remove trailing comma and space
            } else {
                $sizeString = $order->size ?? 'N/A'; // Fallback if not JSON or null
            }

            return [
                'ID Custom Order' => $order->id,
                'Nama Pelanggan' => $order->user->name ?? 'N/A',
                'Deskripsi Desain' => $order->design_description ?? 'N/A',
                'Tipe Bahan' => $order->fabric_type ?? 'N/A', // BARU: Menambahkan kolom Tipe Kain
                'Ukuran (Qty)' => $sizeString,
                'Jumlah Barang (Total Qty)' => $order->qty ?? 'N/A',
                'Total Harga Barang' => $order->total_price,
                'Ongkir' => $order->ongkir,
                'Total Keseluruhan' => $order->total_price + $order->ongkir,
                'DP Dibayar' => $order->dp_paid,
                'Sisa Pembayaran' => $order->remaining_payment,
                'Tipe Pembayaran' => $order->payment_type,
                'Status Pesanan' => $order->status,
                'Tanggal Pesanan' => Carbon::parse($order->order_date)->format('d-m-Y H:i:s'),
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Custom Order',
            'Nama Pelanggan',
            'Deskripsi Desain',
            'Tipe Bahan', // BARU: Menambahkan header Tipe Kain
            'Ukuran (Qty)',
            'Jumlah Barang (Total Qty)',
            'Total Harga Barang',
            'Ongkir',
            'Total Keseluruhan',
            'DP Dibayar',
            'Sisa Pembayaran',
            'Tipe Pembayaran',
            'Status Pesanan',
            'Tanggal Pesanan',
        ];
    }
}