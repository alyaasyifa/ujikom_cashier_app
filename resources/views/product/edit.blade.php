@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                      <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                      <li class="breadcrumb-item active" aria-current="page">Produk</li>
                    </ol>
                  </nav>
                <h1 class="mb-0 fw-bold">Produk</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('products.update', $product['id']) }}" method="POST" class="form-horizontal form-material mx-2" enctype="multipart/form-data">
                            @csrf

                            @if (session('success'))
                            <script>
                                window.onload = function () {
                                    setTimeout(() => {
                                        Swal.fire({
                                            title: 'Sukses!',
                                            text: "{{ session('success') }}",
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            window.location.href = "{{ route('products.index') }}";
                                        });
                                    }, 500);
                                };
                            </script>
                            @endif

                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Nama Produk</label>
                                        <div class="col-md-12">
                                            <input type="text"
                                                class="form-control form-control-line" name="product_name"  value="{{ $product['product_name'] }}" id="product_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Gambar Produk</label>
                                        <div class="col-md-12">
                                            <input type="file" class="form-control form-control-line mt-2" id="image" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Harga</label>
                                        <div class="col-md-12">
                                            <input type="text" id="price" name="price" class="form-control"
                                                oninput="formatRupiah(this)"
                                                value="Rp. {{ number_format($product->price, 0, ',', '.') }}">
                                            <input type="hidden" id="price_raw" name="price_raw" value="{{ $product['price'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-12">Stock</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control form-control-line" id="stock"
                                                value="{{ $product['stock'] }}" name="stock" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol di ujung kanan -->
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary text-white">Ubah Data</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
