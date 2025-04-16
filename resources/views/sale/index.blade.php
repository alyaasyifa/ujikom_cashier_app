@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item">
                            <a href="/" class="link">
                                <i class="mdi mdi-home-outline fs-4"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
                <h1 class="mb-0 fw-bold">Penjualan</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <a href=" " class="btn btn-success text-white">Export Penjualan (.xls)</a>
                    
                        <a href=" " class="btn btn-primary text-white">Tambah Penjualan</a>
                    
                </div>

                <div class="table-responsive">
                    <table class="table" id="tables">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                                <th>Kasir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td class="d-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#saleModal"
                                            onclick="showModal">
                                            Lihat
                                        </button>
                                        <a href=" " class="btn btn-info btn-sm text-white">
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data penjualan</td>
                                </tr>
                            
                        </tbody>                        
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content" id="modal-content">
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- container -->
</div>

<script>


</script>
@endsection
