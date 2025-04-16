@extends('layouts.template')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="index.html" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
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
                            <form action="{{ route('products.store') }}" method="POST"
                                class="form-horizontal form-material mx-2" enctype="multipart/form-data">
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

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                @method('POST')
                                <!-- Full Name & Email dalam satu baris -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Nama Produk</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" name="product_name"
                                                    id="product_name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-12">Gambar Produk</label>
                                            <div class="col-md-12">
                                                <input type="file" class="form-control form-control-line" id="image"
                                                    name="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password & Country dalam satu baris -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-12">Harga</label>
                                            <div class="col-md-12">
                                                <input type="text" id="price" name="price" class="form-control" oninput="formatRupiah(this)">
                                                <input type="hidden" id="price_raw" name="price_raw">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-12">Stok</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control form-control-line" id="stock"
                                                name="stock">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol di ujung kanan -->
                                <div class="form-group">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary text-white">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
