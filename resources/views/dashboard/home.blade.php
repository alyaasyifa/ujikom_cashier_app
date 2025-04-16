@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <h1 class="mb-0 fw-bold">Dashboard</h1> 

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
            </div>

            
                <div class="card mb-4 p-4 mt-4">
                    <div class="fw-semibold fs-3 text-dark">Selamat Datang, Administrator!</div>
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                        <div class="card-body" style="width: 60%; min-width: 300px;">
                            <canvas id="chartBar"></canvas>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center"
                            style="width: 40%; min-width: 200px;">
                            <canvas id="chartCircle" style="max-width: 280px; max-height: 280px;"></canvas>
                        </div>
                    </div>
                </div>
            
                <div class="container-fluid mt-4">
                    <div class="card w-100">
                        <div class="card-body">
                            <h3>Selamat Datang, Petugas!</h3>
                            <div class="card d-block mx-auto text-center w-100">
                                <div class="card-header">
                                    Total Penjualan Hari Ini
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title"> </h3>
                                    <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
                                </div>
                                <div class="card-footer text-muted">
                                    Terakhir diperbarui: 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
@endsection


@push('script')
<script>
document.addEventListener("DOMContentLoaded", function () {


    // Render Bar Chart
    const chartBar = document.getElementById('chartBar');
    if (chartBar) {
        new Chart(chartBar, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Total Penjualan / Hari',
                    data: barChartData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {  beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            max: 20
                        }
                    }
                }
            }
        });
    }


    // Render Pie Chart
    const chartCircle = document.getElementById('chartCircle');
    if (chartCircle) {
        new Chart(chartCircle, {
            type: 'pie',
            data: {
                labels: ['mie', 'bebek', 'ruliminions', 'Obat', 'bakso'],
                datasets: [{
                    label: 'Persentase Penjualan Produk',
                    data: pieChartData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        '#ff6384',
                        '#36a2eb',
                        '#ffce56',
                        '#4bc0c0',
                        '#9966ff'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Produk Terjual Hari Ini'
                    }
                }
            }
        });
    }
});
</script>
@endpush
