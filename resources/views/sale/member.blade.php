@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item">
                            <a href="" class="link"><i class="mdi mdi-home-outline fs-4"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
                <h1 class="mb-0 fw-bold">Penjualan</h1>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <form action="{{ route('sales.storeMember', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <input type="hidden" name="customer_type" value="member">
            <input type="hidden" name="phone" value="{{ $member->phone }}">
            <input type="hidden" name="amount_paid" value="{{ $paymentAmount }}">
            <input type="hidden" name="total_points" value="{{ $earnedPoints }}">

            <div class="row">
                <!-- Produk -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailSales as $detail)
                                        <tr>
                                            <td>{{ $detail->product->product_name }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach

                                    @foreach ($detailSales as $detail)
                                        <input type="hidden" name="product_id[]" value="{{ $detail->product->id }}">
                                        <input type="hidden" name="quantity[]" value="{{ $detail->quantity }}">
                                        <input type="hidden" name="subtotal[]" value="{{ $detail->total_price }}">
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="text-end mt-3">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold mb-1">Total Harga</p>
                                    <p class="fw-bold mb-1">Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Identitas & Poin -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <label class="fw-bold">Nama Member</label>
                            <input type="text" class="form-control mb-3" name="name" value="{{ $member->name }}">

                            <label class="fw-bold">Poin Didapat</label>
                            <input type="text" class="form-control mb-2" name="total_points_display"
                                value="{{ $member->total_points ?? 0 }}" readonly>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="check_point" id="check_point"
                                    value="on" {{ $isFirst ? 'disabled' : '' }}>

                                <label class="form-check-label {{ $isFirst ? 'text-danger' : '' }}" for="check_point">
                                    {{ $isFirst
                                        ? 'Gunakan poin tidak dapat dilakukan pada pembelanjaan pertama.'
                                        : 'Gunakan poin untuk potongan harga.' }}
                                </label>

                                <small class="text-muted">
                                    Poin yang terdapat ditransaksi ini: {{ $earnedPoints }}
                                </small>
                            </div>


                            <div class="text-end mt-3">
                                <button class="btn btn-primary">Selanjutnya</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
