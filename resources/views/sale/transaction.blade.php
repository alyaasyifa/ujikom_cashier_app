@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item">
                            <a href="" class="link">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="sales-form" action="" method="POST">
                            <div class="row">
                                <h4 style="font-size: 25px">Produk yang dipilih</h4>
                                <div class="col-md-6">
                                        <div class="col-md-10">
                                            <div class="d-flex flex-column" style="max-width: 100%;">
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-0"></p>
                                                    <p class="fw-bold mb-0">Rp.</p>
                                                </div>
                                                <div class="d-flex justify-content-between text-muted">
                                                    <p class="mb-0">Rp.</p>
                                                </div>
                                                <hr class="my-2">
                                            </div>
                                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                                        </div>
                                    @endforeach
                                    
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between" style="max-width: 100%; font-size: 20px;">
                                            <p class="fw-bold mb-0">Total</p>
                                            <p class="fw-bold mb-0">Rp.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <label class="me-2 mb-0">Member Status</label>
                                        <p style="color: red; font-size: 13px; margin: 0;">Dapat juga membuat member</p>
                                    </div>
                                    <div class="mb-3">
                                        <select name="customer_type" id="customer_type" class="form-select shadow-none form-control-line">
                                            <option value="non-member">Bukan Member</option>
                                            <option value="member">Member</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="is_member" id="is_member" value="non-member">
                                    <div id="phone-input" class="mb-3" style="display: none;">
                                        <label>Nomor Telepon <span style="color: red; font-size: 13px;">(daftar/gunakan member)</span></label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                    <label>Total Bayar</label>
                                    <input type="text" id="payment-amount" name="amount_paid" class="form-control mb-3" oninput="formatRupiah(this)">
                                    <input type="hidden" id="price_raw" name="amount_paid">
                                    <span id="warning-message" class="text-danger text-sm d-none">Bayaran masih kurang!</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button id="submit-button" type="submit" class="btn btn-primary text-white ms-2" disabled>Pesan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const totalAmount = {{ $grandTotal }};
    const paymentInput = document.getElementById("payment-amount");
    const priceRawInput = document.getElementById("price_raw");
    const warningMessage = document.getElementById("warning-message");
    const submitButton = document.getElementById("submit-button");
    const customerType = document.getElementById("customer_type");
    const phoneInput = document.getElementById("phone-input");
    const isMemberInput = document.getElementById("is_member");
    const phoneField = document.querySelector("input[name='phone']");

    function formatRupiah(element) {
        let value = element.value.replace(/\D/g, "");
        let formatted = new Intl.NumberFormat("id-ID").format(value);
        element.value = value ? "Rp " + formatted : "";
        priceRawInput.value = value || "0";
        validatePayment();
    }

    function validatePayment() {
        const paymentValue = parseInt(priceRawInput.value) || 0;
        const isMember = customerType.value === "member";
        const phoneValue = phoneField.value.trim();

        if (paymentValue === 0) {
            warningMessage.classList.add("d-none");
            submitButton.disabled = true;
        } else if (paymentValue < totalAmount) {
            warningMessage.classList.remove("d-none");
            submitButton.disabled = true;
        } else {
            warningMessage.classList.add("d-none");
            submitButton.disabled = false;
        }
    }

    customerType.addEventListener("change", function () {
        if (this.value === "member") {
            phoneInput.style.display = 'block';
            phoneField.focus();
            isMemberInput.value = "member";
        } else {
            phoneInput.style.display = 'none';
            isMemberInput.value = "non-member";
            phoneField.value = "";
        }

        validatePayment();
    });

    paymentInput.addEventListener("input", function () {
        formatRupiah(this);
    });

    phoneField.addEventListener("input", validatePayment);
});
</script>
@endsection
