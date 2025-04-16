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
                    <a href="{{ route('export.laporan.penjualan' )}}" class="btn btn-success text-white">Export Penjualan (.xls)</a>
                    @if (Auth::user()->role !== 'admin')
                        <a href="{{ route('sales.create') }}" class="btn btn-primary text-white">Tambah Penjualan</a>
                    @endif
                </div>

                @if (session('error'))
                    <script>
                    window.onload = function () {
                        setTimeout(() => {
                            Swal.fire({
                                text: "{{ session('error') }}",
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    };
                    </script>
                @endif

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
                            @forelse ($sales as $index => $sale)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sale->member?->name ?? 'NON-MEMBER' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if (!$sale->member)
                                            {{-- Non-member --}}
                                            Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                                        @elseif ($sale->member && $sale->points_used > 0)
                                            {{-- Member yang pakai poin --}}
                                            Rp {{ number_format($sale->final_price_member, 0, ',', '.') }}
                                            {{-- <span class="badge bg-success ms-1">Pakai Poin</span> --}}
                                        @else
                                            {{-- Member tapi tidak pakai poin --}}
                                            Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                                        @endif
                                    </td>

                                    <td>{{ $sale->user->name ?? '-' }}</td>
                                    <td class="d-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#saleModal"
                                            onclick="showModal({{ $sale->id }})">
                                            Lihat
                                        </button>
                                        <a href="{{ route('sales.invoice.pdf', $sale->id) }}" class="btn btn-info btn-sm text-white">
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
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
    function showModal(saleId) {
        fetch(`/sales/${saleId}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('modal-content').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('modal-content').innerHTML = '<div class="modal-body text-danger">Gagal memuat data</div>';
                console.error(error);
            });
    }
</script>
@endsection
