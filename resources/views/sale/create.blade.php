@extends('layouts.template')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
                </div>
            </div>
        </div>

        <form action=" " method="POST">

            <div class="container mt-4">
                <div class="row">
                    
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card shadow-sm text-center p-3">
                                <img src=" " alt="Product Image" class="product-image" style="max-width: 110px; height: auto; margin: 0 auto;">
                                <div class="card-body">
                                    <h5 class="fw-bold"> </h5>
                                    <p class="text-muted">Stok: <strong class="stock"> </strong></p>
                                    <p class="fw-bold">
                                        Rp. <span class="item-price" data-price=""> </span>
                                    </p>
        
                                    <div class="input-group d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm minus" style="border-radius: 20px 0 0 20px;">-</button>
                                        <input type="text" class="quantity text-center" name="quantity" value="0" readonly style="width: 40px; border-radius: 0;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm plus" style="border-radius: 0 20px 20px 0;">+</button>
                                    </div>
        
                                    <p class="mt-2">Sub Total: <strong class="total-price">Rp. 0</strong></p>
                                </div>
                            </div>
                        </div>
                    
                </div>
        
                <div class="fixed-bottom bg-white border-top p-3 shadow-sm">
                    <div class="position-absolute top-0 end-0 border-top border-warning" style="height: 3px; width: 1010px;">
                    </div>
                    <div class="text-end">
                        <button id="submit-bottom" type="submit" class="btn btn-primary" disabled style="margin-right: 500px;">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </form>        
    </div>

    <style>
    .input-group {
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .quantity {
        width: 40px;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent;
        font-weight: bold;
        text-align: center;
    }

    button.minus, button.plus {
        background-color: transparent;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        font-size: 20px;
        font-weight: bold;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%; /* Biar bulat */
        transition: 0.2s ease-in-out;
    }

    button.minus:hover, button.plus:hover {
        background-color: rgba(0, 0, 0, 0.1); /* Efek hover biar elegan */
    }

    </style>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            cartItems.forEach(item => {
                const quantityInput = item.querySelector(".quantity");
                const minusButton = item.querySelector(".minus");
                const plusButton = item.querySelector(".plus");
                const stockElement = item.querySelector(".stock");
                const stock = parseInt(stockElement.textContent);

                minusButton.addEventListener("click", function() {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue > 0) {
                        quantityInput.value = currentValue - 1;
                        updateTotal();
                    }
                });

                plusButton.addEventListener("click", function() {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue < stock) {
                        quantityInput.value = currentValue + 1;
                        updateTotal();
                    } else {
                        alert("Stok habis!");
                    }
                });
            });

            updateTotal();
        });
    </script>
@endpush
