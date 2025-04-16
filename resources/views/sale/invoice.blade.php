@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="#" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                    </ol>
                </nav>
                <h1 class="mb-0 fw-bold">Pembayaran</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-start mb-4">
                            <a class="btn btn-primary me-2" href="{{ route('sales.invoice.pdf', $sale->id) }}">Unduh</a>
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                        @if ($sale->member)
                        <table>
                            <tr>
                                <td>NOMBER HP</td>
                                <td>&nbsp;: &nbsp;</td>
                                <td>{{ $sale->member->phone }}</td>
                            </tr>
                            <tr>
                                <td>MEMBER SEJAK</td>
                                <td>&nbsp;: &nbsp;</td>
                                <td>{{ $sale->member->created_at->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>MEMBER POIN</td>
                                <td>&nbsp;: &nbsp;</td>
                                <td>{{ $sale->member->total_points }}</td>
                            </tr>
                        </table>
                    @endif
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <p class="mb-0">Invoice - #{{ $sale->id }}</p>
                                <p class="mb-0">{{ $sale->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->detailSale as $detail)
                                    <tr>
                                        <td>{{ $detail->product->product_name }}</td>
                                        <td>Rp. {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>Rp. {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row mt-4 bg-light">
                            <div class="col-9 py-3">
                                <div class="row">
                                    <div class="col-4">
                                        <p class="text-muted mb-1">POIN DIGUNAKAN</p>
                                        <p class="fw-bold mb-0">{{ $sale->points_used ?? 0 }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted mb-1">KASIR</p>
                                        <p class="fw-bold mb-0">{{ $sale->user->name ?? '-' }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted mb-1">KEMBALIAN</p>
                                        <p class="fw-bold mb-0">Rp. {{ number_format($sale->change ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="bg-dark text-white p-3 rounded">
                                    <p class="mb-1">TOTAL</p>
                                    @if ($sale->points_used)
                                        <h5 class="mb-0 fs-4 text-white">
                                            <del>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</del>
                                        </h5>
                                        <h4 class="mb-0 fs-2 text-white">Rp. {{ number_format($sale->final_price_member, 0, ',', '.') }}</h4>
                                    @else
                                        <h4 class="mb-0 fs-2 text-white">Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</h4>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>
        </div>
    </div>
</div>
@endsection
