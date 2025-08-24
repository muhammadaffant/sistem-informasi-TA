<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// Implementasikan ShouldAutoSize untuk lebar kolom otomatis
// dan WithEvents untuk menambahkan baris total di akhir
class LaporanPenjualanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = OrderItem::query()->with('product', 'order');

        $query->whereHas('order', function ($q) {
            if ($this->startDate) {
                $q->whereDate('created_at', '>=', $this->startDate);
            }
            if ($this->endDate) {
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
            'Total Harga Produk',
            'Ongkir',
            'Total Keseluruhan',
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
            optional($item->order)->created_at ? $item->order->created_at->format('d-m-Y') : '-',
        ];
    }

    /**
     * Mendaftarkan event untuk dieksekusi selama proses export.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Event ini akan berjalan setelah sheet selesai dibuat
            AfterSheet::class => function(AfterSheet $event) {
                // Dapatkan objek sheet aktif
                $sheet = $event->sheet->getDelegate();

                // Dapatkan nomor baris terakhir yang berisi data
                $lastRow = $sheet->getHighestRow();

                // Tentukan baris untuk total (satu baris di bawah data terakhir)
                $totalRow = $lastRow + 1;

                // Baris pertama yang berisi data (setelah heading)
                $firstDataRow = 2;

                // Tambahkan label "Total"
                $sheet->setCellValue("D{$totalRow}", 'Total Keseluruhan:');

                // Tambahkan formula SUM untuk kolom yang relevan
                // Kolom E: Jumlah
                $sheet->setCellValue("E{$totalRow}", "=SUM(E{$firstDataRow}:E{$lastRow})");

                // Kolom G: Total Harga Produk
                $sheet->setCellValue("G{$totalRow}", "=SUM(G{$firstDataRow}:G{$lastRow})");
                
                // Kolom H: Ongkir
                $sheet->setCellValue("H{$totalRow}", "=SUM(H{$firstDataRow}:H{$lastRow})");
                
                // Kolom I: Total Keseluruhan
                $sheet->setCellValue("I{$totalRow}", "=SUM(I{$firstDataRow}:I{$lastRow})");

                // Beri style bold pada baris total
                $sheet->getStyle("D{$totalRow}:I{$totalRow}")->getFont()->setBold(true);
            },
        ];
    }
}
