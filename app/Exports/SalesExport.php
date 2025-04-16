<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::with('member')->get()->map(function ($sale) {
            return [
                'Nama Pelanggan'     => $sale->member->name ?? 'Bukan Member',
                'No HP Pelanggan'    => $sale->member->phone ?? '-',
                'Poin Pelanggan'     => $sale->member->total_points ?? '0',
                'Produk'             => $sale->sales_product,
                'Total Harga'        => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                'Total Bayar'        => 'Rp ' . number_format($sale->amount_paid, 0, ',', '.'),
                'Total Setelah Diskon'  => 'Rp ' . number_format($sale->final_price_member ?? 0, 0, ',', '.'),
                'Total Kembalian'    => 'Rp ' . number_format($sale->change ?? 0, 0, ',', '.'),
                'Tanggal Pembelian'  => $sale->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Setelah Diskon',
            'Total Kembalian',
            'Tanggal Pembelian',
        ];
    }
}
