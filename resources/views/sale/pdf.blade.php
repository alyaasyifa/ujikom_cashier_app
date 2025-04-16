<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }

        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .petugas {
            text-align: left;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 4px 0;
            text-align: left;
        }

        .total td {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 11px;
            color: #000;
        }

        .receipt-border {
            border: 1px solid black;
            padding: 15px;
            max-width: 300px;
            margin: 0 auto;
            background: #fff;
        }

    </style>
</head>

<body>
<div class="receipt-border">
    <div class="header">Indo April</div>

        <div class="petugas">
            Petugas: {{ $sale->user->name }}<br>
            Tanggal: {{ $sale->created_at->timezone('Asia/Jakarta')
            ->translatedFormat('d F Y H:i') }}
        </div>

        <div class="info">
            <p>Status: {{ $sale->member ? 'Member' : 'Non Member' }}</p>
            <p>HP: {{ $sale->member?->phone ?? '-' }}</p>
            <p>Gabung: {{ $sale->member?->created_at?->format('d F Y') ?? '-' }}</p>
            <p>Poin Saat Ini: {{ $sale->member?->total_points ?? '-' }}</p>
        </div>

        <div class="line"></div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->detailSale as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->product->price, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>

        <table>
            <tr class="total">
                <td colspan="3">Total Harga</td>
                <td>{{ number_format($sale->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td colspan="3">Bayar</td>
                <td>{{ number_format($sale->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3">Poin Digunakan</td>
                <td>{{ $sale->points_used }}</td>
            </tr>
            @if ($sale->member && $sale->points_used > 0)
            <tr class="total">
                <td colspan="3">Harga Akhir</td>
                <td>{{ number_format($sale->final_price_member, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total">
                <td colspan="3">Kembalian</td>
                <td>{{ number_format($sale->change, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="footer">
            <p><strong>Terima kasih atas pembelian Anda!</strong></p>
        </div>

    </div>

</body>
</html>
