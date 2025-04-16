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
                            <a class="btn btn-primary me-2" href=" ">Unduh</a>
                            <a href=" " class="btn btn-secondary">Kembali</a>
                        </div>
                       
                        <table>
                            <tr>
                                <td>NOMBER HP</td>
                                <td>&nbsp;: &nbsp;</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td>MEMBER SEJAK</td>
                                <td>&nbsp;: &nbsp;</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td>MEMBER POIN</td>
                                <td>&nbsp;: &nbsp;</td>
                                <td> </td>
                            </tr>
                        </table>
                    
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <p class="mb-0">Invoice - #</p>
                                <p class="mb-0"></p>
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
                                
                                    <tr>
                                        <td> </td>
                                        <td>Rp. </td>
                                        <td> </td>
                                        <td>Rp. </td>
                                    </tr>
                                
                            </tbody>
                        </table>

                        <div class="row mt-4 bg-light">
                            <div class="col-9 py-3">
                                <div class="row">
                                    <div class="col-4">
                                        <p class="text-muted mb-1">POIN DIGUNAKAN</p>
                                        <p class="fw-bold mb-0"> </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted mb-1">KASIR</p>
                                        <p class="fw-bold mb-0"> </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted mb-1">KEMBALIAN</p>
                                        <p class="fw-bold mb-0">Rp. </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="bg-dark text-white p-3 rounded">
                                    <p class="mb-1">TOTAL</p>
                                 
                                        <h5 class="mb-0 fs-4 text-white">
                                            <del>Rp. </del>
                                        </h5>                                      
                                        <h4 class="mb-0 fs-2 text-white">Rp. </h4>
                                    
                                        <h4 class="mb-0 fs-2 text-white">Rp. </h4>
                                    
                                
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
