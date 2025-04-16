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

            @if(Auth::user()->role == 'admin')
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
            @elseif(Auth::user()->role == 'kasir')
                <div class="container-fluid mt-4">
                    <div class="card w-100">
                        <div class="card-body">
                            <h3>Selamat Datang, Petugas!</h3>
                            <div class="card d-block mx-auto text-center w-100">
                                <div class="card-header">
                                    Total Penjualan Hari Ini :
                                </div>
                                <div class="card-body">
                                    <h4>
                                        {{ $totalPenjualanHariIni }}
                                    </h4>
                                    <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
                                </div>
                                <div class="card-footer text-muted">
                                    Terakhir diperbarui: {{ $today }}
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
    const penjualanTahunan = @json($penjualanTahunan); // array of { tanggal, member, non_member }
    const produkTerlaris = @json($produkTerlaris);      // array of { label, value }

    // Bar chart: Member vs Non-member
    const barChartLabels = penjualanTahunan.map(item => item.tanggal);
    const memberData = penjualanTahunan.map(item => item.member);
    const nonMemberData = penjualanTahunan.map(item => item.non_member);

    const chartBar = document.getElementById('chartBar');
    if (chartBar) {
        new Chart(chartBar, {
            type: 'bar',
            data: {
                labels: barChartLabels,
                datasets: [
                    {
                        label: 'Non Member',
                        data: nonMemberData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Member',
                        data: memberData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Penjualan Hari ini'
                    }
                }
            }
        });
    }

    // PIE CHART - Produk Terlaris
    const pieChartLabels = produkTerlaris.map(p => p.label);
    const pieChartData = produkTerlaris.map(p => p.value);

    function generateColor(index) {
        const colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#F67019', '#00A950', '#C9CBCF', '#F53794', '#009688'
        ];
        return colors[index % colors.length];
    }

    if (produkTerlaris.length > 0) {
        const backgroundColors = produkTerlaris.map((_, i) => generateColor(i) + '33'); // 33 for transparency
        const borderColors = produkTerlaris.map((_, i) => generateColor(i));

        const chartCircle = document.getElementById('chartCircle');
        if (chartCircle) {
            new Chart(chartCircle, {
                type: 'pie',
                data: {
                    labels: pieChartLabels,
                    datasets: [{
                        label: 'Persentase Penjualan Produk',
                        data: pieChartData,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
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
    }
});
</script>

@endpush
