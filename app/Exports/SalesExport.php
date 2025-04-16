<?php
namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithStyles
{
    public function collection()
    {
        return Sale::with('detailSale.product', 'member')->get()->map(function ($sale) {
            $productsData = [];

            // Loop through each product in the sale's details
            foreach ($sale->detailSale as $detail) {
                $productsData[] = [
                    'Nama Pelanggan'         => $sale->member->name ?? 'Bukan Member',
                    'No HP Pelanggan'        => $sale->member->phone ?? '-',
                    'Poin Pelanggan'         => $sale->member->total_points ?? '0',
                    'Nama Produk'            => $detail->product->product_name,
                    'Quantity'               => $detail->quantity,
                    'Harga Satuan'           => 'Rp ' . number_format($detail->product->price, 0, ',', '.'),
                    'Total Harga'            => 'Rp ' . number_format($detail->total_price, 0, ',', '.'),
                    'Total Bayar'            => 'Rp ' . number_format($sale->amount_paid, 0, ',', '.'),
                    'Total Setelah Diskon'   => 'Rp ' . number_format($sale->final_price_member ?? 0, 0, ',', '.'),
                    'Total Kembalian'        => 'Rp ' . number_format($sale->change ?? 0, 0, ',', '.'),
                    'Tanggal Pembelian'      => $sale->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                ];
            }

            return $productsData;
        })->flatten(1); // Flatten the array to avoid nested arrays for products
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Nama Produk',
            'Quantity',
            'Harga Satuan',
            'Total Harga',
            'Total Bayar',
            'Total Setelah Diskon',
            'Total Kembalian',
            'Tanggal Pembelian',
        ];
    }

    public function startCell(): string
    {
        return 'A3'; // Mulai data dari baris ke-3
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menulis "ALYA STORE" di sel A1
                $event->sheet->setCellValue('A1', 'ALYA STORE');

                // Merge sel A1 sampai K1 (total 11 kolom)
                $event->sheet->mergeCells('A1:K1');

                // Styling teks header toko
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Menebalkan baris heading data (baris ke-3)
            3 => ['font' => ['bold' => true]],
        ];
    }
}
