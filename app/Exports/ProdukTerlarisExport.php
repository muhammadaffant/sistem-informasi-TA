<?php

namespace App\Exports;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProdukTerlarisExport implements FromQuery, WithHeadings, WithMapping
{
    protected $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

// app/Exports/ProdukTerlarisExport.php

public function query()
{
    return OrderItem::query()
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        
        // --- UBAH BAGIAN INI ---
        ->where('orders.status', 'Success') // Tambahan: Hanya hitung dari order yang sukses
        ->whereYear('orders.created_at', $this->year) // Gunakan kolom created_at
        // -------------------------

        ->select(
            'products.product_name',
            DB::raw('SUM(order_items.qty) as total_terjual')
        )
        ->groupBy('products.product_name')
        ->orderBy('total_terjual', 'desc')
        ->limit(10);
}

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Total Unit Terjual',
        ];
    }

    public function map($row): array
    {
        return [
            $row->product_name,
            $row->total_terjual,
        ];
    }
}