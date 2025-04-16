<div class="modal-header">
    <h1 class="modal-title fs-5" id="saleModalLabel">Detail Penjualan</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="d-flex align-items-start small text-muted">
        <div class="me-5">
            <p class="mb-1">Member Status: {{ $sale->member ? 'Member' : 'Non Member'}}</p>
            <p class="mb-1">No. HP: {{ $sale->member->phone ?? '-' }}</p>
            <p class="mb-1">Poin Member: {{ $sale->member->total_points ?? '-'}}</p>
        </div>
        <div>
            @if ($sale->member)
            <p class="mb-1">Bergabung Sejak: {{ $sale->member->created_at->format('d F Y') }}</p>
            @else
                <p class="mb-1">Bergabung Sejak: -</p>
            @endif
        </div>
    </div>


    <ul class="list-group w-100"> <!-- Buat list lebar penuh -->
        <!-- Header -->
        <li class="list-group-item list-header d-flex px-3">
            <span class="flex-grow-1">Nama Produk</span>
            <span class="w-25 text-center">Qty</span>
            <span class="w-25 text-end">Harga</span>
            <span class="w-25 text-end">Sub Total</span>
        </li>

        @foreach ($sale->detailSale as $detail)
            <!-- Isi Data -->
            <li class="list-group-item d-flex px-3">
                <span class="flex-grow-1">{{ $detail->product->product_name }}</span>
                <span class="w-25 text-center">{{ $detail->quantity }}</span>
                <span class="w-25 text-end">Rp
                    {{ number_format($detail->product->price, 0, ',', '.') }}</span>
                <span class="w-25 text-end">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</span>
            </li>
        @endforeach

        <!-- Total -->
        <li class="list-group-item bg-light fw-bold d-flex justify-content-end px-3">
            <span class="me-3">Total:</span>
            <span>
                @if (!$sale->member)
                    Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                @elseif ($sale->points_used > 0)
                    Rp {{ number_format($sale->final_price_member, 0, ',', '.') }}
                    {{-- <span class="badge bg-success ms-1">Pakai Poin</span> --}}
                @else
                    Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                @endif
            </span>

        </li>

        <p class="text-muted text-center mb-0">Dibuat pada: {{ $sale->created_at }}</p>
        <p class="text-muted text-center mb-0">Oleh: {{ $sale->user->name }}</p>

        <div class="text-end mt-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
</div>
