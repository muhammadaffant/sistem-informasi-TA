<?php

namespace App\Exports;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanPenjualanExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // method query() tidak berubah
        public function query()
        {
            $query = OrderItem::query()->with('product', 'order');

            $query->whereHas('order', function ($q) {
                if ($this->startDate) {
                    // Ganti ke whereDate yang lebih efisien
                    $q->whereDate('created_at', '>=', $this->startDate);
                }
                if ($this->endDate) {
                    // Ganti ke whereDate yang lebih efisien
                    $q->whereDate('created_at', '<=', $this->endDate);
                }
            })->orderBy('created_at', 'asc');
            
            return $query;
        }

    public function headings(): array
    {
        return [
            'ID Order Item',
            'Nama Produk',
            'Warna',
            'Ukuran',
            'Jumlah',
            'Harga Satuan',
            'Total Harga Produk', // Diubah agar lebih jelas
            'Ongkir', // <-- KOLOM BARU
            'Total Keseluruhan', // <-- KOLOM BARU
            'Tanggal Pesanan',
        ];
    }
        public function map($item): array
        {
            return [
                $item->id,
                optional($item->product)->product_name ?? '-',
                $item->color,
                $item->size,
                $item->qty,
                $item->price,
                $item->price * $item->qty,
                optional($item->order)->ongkir ?? 0,
                optional($item->order)->amount ?? 0,
                // --- UBAH BAGIAN INI ---
                optional($item->order)->created_at ? $item->order->created_at->format('d-m-Y') : '-',
            ];
        }
}