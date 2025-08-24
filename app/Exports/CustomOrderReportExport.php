<?php

namespace App\Exports;

use App\Models\CustomOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class CustomOrderReportExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        $query = CustomOrder::query()->with('user');

        if ($this->startDate) {
            $query->whereDate('order_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('order_date', '<=', $this->endDate);
        }

        return $query;
    }

    /**
    * @var CustomOrder $order
    * @return array
    */
    public function map($order): array
    {
        $sizeDetails = json_decode($order->size, true);
        $sizeString = '';
        if (is_array($sizeDetails)) {
            foreach ($sizeDetails as $item) {
                $sizeString .= $item['size'] . ' (' . $item['quantity'] . ' pcs), ';
            }
            $sizeString = rtrim($sizeString, ', ');
        } else {
            $sizeString = $order->size ?? 'N/A';
        }

        return [
            $order->id,
            $order->user->name ?? 'N/A',
            $order->design_description ?? 'N/A',
            $order->fabric_type ?? 'N/A',
            $sizeString,
            $order->qty ?? 0,
            $order->total_price,
            $order->ongkir,
            $order->total_price + $order->ongkir,
            // $order->dp_paid,
            // $order->remaining_payment,
            $order->payment_type,
            $order->status,
            Carbon::parse($order->order_date)->format('d-m-Y H:i:s'),
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID Custom Order',
            'Nama Pelanggan',
            'Warna',
            'Tipe Bahan',
            'Ukuran (Qty)',
            'Jumlah Barang (Total Qty)',
            'Total Harga Barang',
            'Ongkir',
            'Total Keseluruhan',
            // 'DP Dibayar',
            // 'Sisa Pembayaran',
            'Tipe Pembayaran',
            'Status Pesanan',
            'Tanggal Pesanan',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $totalRow = $lastRow + 1;
                $firstDataRow = 2; // Data dimulai dari baris ke-2 setelah heading

                // Tambahkan label "Total"
                $sheet->setCellValue("E{$totalRow}", 'Total Keseluruhan:');

                // Kolom F: Jumlah Barang (Total Qty)
                $sheet->setCellValue("F{$totalRow}", "=SUM(F{$firstDataRow}:F{$lastRow})");

                // Kolom G: Total Harga Barang
                $sheet->setCellValue("G{$totalRow}", "=SUM(G{$firstDataRow}:G{$lastRow})");
                
                // Kolom H: Ongkir
                $sheet->setCellValue("H{$totalRow}", "=SUM(H{$firstDataRow}:H{$lastRow})");
                
                // Kolom I: Total Keseluruhan
                $sheet->setCellValue("I{$totalRow}", "=SUM(I{$firstDataRow}:I{$lastRow})");
                
                // Kolom J: DP Dibayar
                // $sheet->setCellValue("J{$totalRow}", "=SUM(J{$firstDataRow}:J{$lastRow})");
                
                // Kolom K: Sisa Pembayaran
                // $sheet->setCellValue("K{$totalRow}", "=SUM(K{$firstDataRow}:K{$lastRow})");

                // Beri style bold pada baris total
                $sheet->getStyle("E{$totalRow}:K{$totalRow}")->getFont()->setBold(true);
            },
        ];
    }
}
