@extends('layouts.template')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item">
                                <a href="index.html" class="link">
                                    <i class="mdi mdi-home-outline fs-4"></i>
                                </a>
                            </li>
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

                                <div class="text-end mb-3">
                                    <a href="{{ route('products.create') }}" class="btn btn-primary text-white">Tambah Produk</a>
                                </div>

                            <div class="table-responsive">
                                <table class="table" id="">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Stok</th>

                                                {{-- <th scope="col"></th> --}}

                                        </tr>
                                    </thead>

                                    @php
                                        $no = 1;
                                    @endphp

                                    @foreach ($products as $item )
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $no++ }}</th>
                                            <td>
                                                <img src="{{ asset('image/' . $item->image) }}" alt="Product Image" width="100">
                                            </td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ 'Rp. ' . number_format($item->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->stock }}</td>

                                            <td>
                                                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning">Edit</a>

                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal-{{ $item->id }}">
                                                    Update Stok
                                                </button>

                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $item->id }}">
                                                    Hapus
                                                </button>
                                            </td>

                                        </tr>

                                            <!-- Modal Update Stok -->
                                            <div class="modal fade" id="confirmUpdateModal-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="confirmUpdateModalLabel">Update Stok Produk</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if (session('success'))
                                                            <script>
                                                                window.onload = function () {
                                                                    setTimeout(() => {
                                                                        Swal.fire({
                                                                            title: 'Sukses!',
                                                                            text: "{{ session('success') }}",
                                                                            icon: 'success',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }, 500);
                                                                };
                                                                </script>
                                                            @endif

                                                            <form action="{{ route('updateStock', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="mb-3">
                                                                    <label for="product_name" class="form-label">Nama Produk</label>
                                                                    <input type="text" class="form-control" id="product_name" value="{{ $item->product_name }}" readonly>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="stock" class="form-label">Stok</label>
                                                                    <input type="number" class="form-control" id="stock" name="stock" value="{{ $item->stock }}" required>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus Produk -->
                                            <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="confirmDeleteModalLabel">Konfirmasi Hapus</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Yakin ingin menghapus produk ini?</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('products.destroy', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
