<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
        }

        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ddd;
            font-weight: bold;
        }

        .total {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

<body>

    <div class="header">Indo April</div>

    <div class="info">
        <p>Member Status: </p>
        <p>No. HP: </p>
        <p>Bergabung Sejak: </p>
        <p>Poin Member Saat Ini: </p>
    </div>

    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Sub Total</th>
        </tr>
  
            <tr>
                <td> </td>
                <td> </td>
                <td>Rp. </td>
                <td>Rp . </td>
            </tr>
      
    </table>

    <table>
        <tr class="total">
            <td colspan="3">Total Harga</td>
            <td>Rp </td>
        </tr>
        <tr>
            <td colspan="3">Poin Digunakan</td>
            <td></td>
        </tr>
        <tr class="total">
            <td colspan="3">Harga Setelah Poin</td>
            <td>Rp </td>
        </tr>
        <tr class="total">
            <td colspan="3">Total Kembalian</td>
            <td>Rp </td>
        </tr>
    </table>

    <div class="footer">
        <p> | </p>
        <p><strong>Terima kasih atas pembelian Anda!</strong></p>
    </div>

</body>

</html>
