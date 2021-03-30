@extends('layouts.base_website')

@section('title', 'Dashboard')
@section('dashboard', true)

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 2 ? route('admin.inventori.pembelian-buku.list') : '#' }}">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-truck text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $belibuku }} transaksi</h2>
                            <p class="mb-0">Pembelian Buku</p>
                        </div>
                        <div class="card-content">
                            <div id="pembelian-buku"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 2 ? route('admin.inventori.penjualan-buku.list') : '#' }}">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-success p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-credit-card text-success font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $jualbuku }} transaksi</h2>
                            <p class="mb-0">Penjualan Buku</p>
                        </div>
                        <div class="card-content">
                            <div id="penjualan-buku"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ Auth::user()->role === 0 || Auth::user()->role === 1 ? route('admin.inventori.retur-pembelian.list') : '#' }}">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-danger p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-x text-danger font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $returbeli }} transaksi</h2>
                            <p class="mb-0">Retur Pembelian</p>
                        </div>
                        <div class="card-content">
                            <div id="retur-pembelian"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ Auth::user()->role === 0 || Auth::user()->role === 1 ? route('admin.inventori.retur-penjualan.list') : '#' }}">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-warning p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-x text-warning font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $returjual }} transaksi</h2>
                            <p class="mb-0">Retur Penjualan</p>
                        </div>
                    </a>
                    <div class="card-content">
                        <div id="retur-penjualan"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-end">
                        <h4 class="card-title">Riwayat Penjualan</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-start">
                                <div class="mr-2">
                                    <p class="mb-50 text-bold-600">Bulan Ini</p>
                                    <h2 class="text-bold-400">
                                        <sup class="font-medium-1">Rp.</sup>
                                        @foreach($laporpenjualan as $data)
                                        @if(substr($data['bulan'], 0, 3) == date('M'))
                                        <span class="text-success">{{ number_format($data['value'], 0, '', '.') }}</span>
                                        @endif
                                        @endforeach
                                    </h2>
                                </div>
                                <div>
                                    <p class="mb-50 text-bold-600">Bulan Lalu</p>
                                    <h2 class="text-bold-400">
                                        <sup class="font-medium-1">Rp.</sup>
                                        @foreach($laporpenjualan as $data)
                                        @if(substr($data['bulan'], 0, 3) == date("M", strtotime("-1 month")))
                                        <span>{{ number_format($data['value'], 0, '', '.') }}</span>
                                        @endif
                                        @endforeach
                                    </h2>
                                </div>

                            </div>
                            <div id="penjualan-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-end">
                        <h4 class="mb-0">Perbandingan Piutang</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body px-0 pb-0">
                            <div id="perbandingan-piutang" class="mt-75"></div>
                            <div class="row text-center mx-0">
                                <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                                    <p class="mb-50">Penjualan Lunas</p>
                                    <p class="font-large-1 text-bold-700">{{ number_format($terbayar->harga_total, 0, '', '.') }}</p>
                                </div>
                                <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                                    <p class="mb-50">Piutang</p>
                                    <p class="font-large-1 text-bold-700">{{ number_format($piutang->harga_total, 0, '', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dashboard Ecommerce ends -->
@endsection
@section('page-js')
<script>
    var $primary = '#7367F0';
    var $success = '#28C76F';
    var $danger = '#EA5455';
    var $warning = '#FF9F43';
    var $info = '#00cfe8';
    var $primary_light = '#A9A2F6';
    var $danger_light = '#f29292';
    var $success_light = '#55DD92';
    var $warning_light = '#ffc085';
    var $info_light = '#1fcadb';
    var $strok_color = '#b9c3cd';
    var $label_color = '#e7e7e7';
    var $white = '#fff';

    // Line Area Chart - 1
    // ----------------------------------

    var gainedlineChartoptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false,
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        },
        },
        colors: [$primary],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [{
        name: 'Pembelian',
        data: [{{ isset($databeli[0]) ? $databeli[0]->qty : 0 }}, {{ isset($databeli[1]) ? $databeli[1]->qty : 0 }}, {{ isset($databeli[2]) ? $databeli[2]->qty : 0 }}, {{ isset($databeli[3]) ? $databeli[3]->qty : 0 }}, {{ isset($databeli[4]) ? $databeli[4]->qty : 0 }}, {{ isset($databeli[5]) ? $databeli[5]->qty : 0 }}, {{ isset($databeli[6]) ? $databeli[6]->qty : 0 }}]
        }],

        xaxis: {
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        }
        },
        yaxis: [{
        y: 0,
        offsetX: 0,
        offsetY: 0,
        padding: { left: 0, right: 0 },
        }],
        tooltip: {
        x: { show: false }
        },
    }

    var gainedlineChart = new ApexCharts(
        document.querySelector("#pembelian-buku"),
        gainedlineChartoptions
    );

    gainedlineChart.render();



    // Line Area Chart - 2
    // ----------------------------------

    var revenuelineChartoptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false,
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        },
        },
        colors: [$success],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [{
        name: 'Penjualan',
        data: [{{ isset($datajual[0]) ? $datajual[0]->qty : 0 }}, {{ isset($datajual[1]) ? $datajual[1]->qty : 0 }}, {{ isset($datajual[2]) ? $datajual[2]->qty : 0 }}, {{ isset($datajual[3]) ? $datajual[3]->qty : 0 }}, {{ isset($datajual[4]) ? $datajual[4]->qty : 0 }}, {{ isset($datajual[5]) ? $datajual[5]->qty : 0 }}, {{ isset($datajual[6]) ? $datajual[6]->qty : 0 }}]
        }],

        xaxis: {
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        }
        },
        yaxis: [{
        y: 0,
        offsetX: 0,
        offsetY: 0,
        padding: { left: 0, right: 0 },
        }],
        tooltip: {
        x: { show: false }
        },
    }

    var revenuelineChart = new ApexCharts(
        document.querySelector("#penjualan-buku"),
        revenuelineChartoptions
    );

    revenuelineChart.render();


    // Line Area Chart - 3
    // ----------------------------------

    var saleslineChartoptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false,
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        },
        },
        colors: [$danger],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [{
        name: 'Retur Pembelian',
        data: [{{ isset($datareturbeli[0]) ? $datareturbeli[0]->qty : 0 }}, {{ isset($datareturbeli[1]) ? $datareturbeli[1]->qty : 0 }}, {{ isset($datareturbeli[2]) ? $datareturbeli[2]->qty : 0 }}, {{ isset($datareturbeli[3]) ? $datareturbeli[3]->qty : 0 }}, {{ isset($datareturbeli[4]) ? $datareturbeli[4]->qty : 0 }}, {{ isset($datareturbeli[5]) ? $datareturbeli[5]->qty : 0 }}, {{ isset($datareturbeli[6]) ? $datareturbeli[6]->qty : 0 }}]
        }],

        xaxis: {
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        }
        },
        yaxis: [{
        y: 0,
        offsetX: 0,
        offsetY: 0,
        padding: { left: 0, right: 0 },
        }],
        tooltip: {
        x: { show: false }
        },
    }

    var saleslineChart = new ApexCharts(
        document.querySelector("#retur-pembelian"),
        saleslineChartoptions
    );

    saleslineChart.render();

    // Line Area Chart - 4
    // ----------------------------------

    var orderlineChartoptions = {
        chart: {
        height: 100,
        type: 'area',
        toolbar: {
            show: false,
        },
        sparkline: {
            enabled: true
        },
        grid: {
            show: false,
            padding: {
            left: 0,
            right: 0
            }
        },
        },
        colors: [$warning],
        dataLabels: {
        enabled: false
        },
        stroke: {
        curve: 'smooth',
        width: 2.5
        },
        fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 0.9,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
        },
        series: [{
        name: 'Retur Penjualan',
        data: [{{ isset($datareturjual[0]) ? $datareturjual[0]->qty : 0 }}, {{ isset($datareturjual[1]) ? $datareturjual[1]->qty : 0 }}, {{ isset($datareturjual[2]) ? $datareturjual[2]->qty : 0 }}, {{ isset($datareturjual[3]) ? $datareturjual[3]->qty : 0 }}, {{ isset($datareturjual[4]) ? $datareturjual[4]->qty : 0 }}, {{ isset($datareturjual[5]) ? $datareturjual[5]->qty : 0 }}, {{ isset($datareturjual[6]) ? $datareturjual[6]->qty : 0 }}]
        }],

        xaxis: {
        labels: {
            show: false,
        },
        axisBorder: {
            show: false,
        }
        },
        yaxis: [{
        y: 0,
        offsetX: 0,
        offsetY: 0,
        padding: { left: 0, right: 0 },
        }],
        tooltip: {
        x: { show: false }
        },
    }

    var orderlineChart = new ApexCharts(
        document.querySelector("#retur-penjualan"),
        orderlineChartoptions
    );

    orderlineChart.render();
    // revenue-chart Chart
    // -----------------------------

    var revenueChartoptions = {
        chart: {
        height: 270,
        toolbar: { show: false },
        type: 'line',
        },
        stroke: {
        curve: 'smooth',
        dashArray: [0, 8],
        width: [4, 2],
        },
        grid: {
        borderColor: $label_color,
        },
        legend: {
        show: false,
        },
        colors: [$danger_light, $strok_color],

        fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            inverseColors: false,
            gradientToColors: [$primary, $strok_color],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
        },
        },
        markers: {
        size: 0,
        hover: {
            size: 5
        }
        },
        xaxis: {
        labels: {
            style: {
            colors: $strok_color,
            }
        },
        axisTicks: {
            show: false,
        },
        categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        axisBorder: {
            show: false,
        },
        tickPlacement: 'on',
        },
        yaxis: {
        tickAmount: 5,
        labels: {
            style: {
            color: $strok_color,
            },
            formatter: function (val) {
            return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
            }
        }
        },
        tooltip: {
        x: { show: false }
        },
        series: [{
        name: "Penjualan",
        data: [{{ $laporpenjualan[0]['value'] }}, {{ $laporpenjualan[1]['value'] }}, {{ $laporpenjualan[2]['value'] }}, {{ $laporpenjualan[3]['value'] }}, {{ $laporpenjualan[4]['value'] }}, {{ $laporpenjualan[5]['value'] }}, {{ $laporpenjualan[6]['value'] }}, {{ $laporpenjualan[7]['value'] }}, {{ $laporpenjualan[8]['value'] }}, {{ $laporpenjualan[9]['value'] }}, {{ $laporpenjualan[10]['value'] }}, {{ $laporpenjualan[11]['value'] }}]
        }
        ],

    }
    var revenueChart = new ApexCharts(
        document.querySelector("#penjualan-chart"),
        revenueChartoptions
    );

    revenueChart.render();

    // Goal Overview  Chart
    // -----------------------------
    var goalChartoptions = {
        chart: {
        height: 250,
        type: 'radialBar',
        sparkline: {
            enabled: true,
        },
        dropShadow: {
            enabled: true,
            blur: 3,
            left: 1,
            top: 1,
            opacity: 0.1
        },
        },
        colors: [$success],
        plotOptions: {
        radialBar: {
            size: 110,
            startAngle: -150,
            endAngle: 150,
            hollow: {
            size: '77%',
            },
            track: {
            background: $strok_color,
            strokeWidth: '50%',
            },
            dataLabels: {
            name: {
                show: false
            },
            value: {
                offsetY: 18,
                color: '#99a2ac',
                fontSize: '4rem'
            }
            }
        }
        },
        fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#00b5b5'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        },
        },
        series: [{{ $terbayar->harga_total > $piutang->harga_total ? number_format((float) ($terbayar->harga_total / ($terbayar->harga_total + $piutang->harga_total))*100, 1, '.', '') :($terbayar->harga_total == $piutang->harga_total ? '0' : number_format((float) 0 - ($piutang->harga_total / ($terbayar->harga_total + $piutang->harga_total))*100, 1, '.', ''))  }}],
        stroke: {
        lineCap: 'round'
        },

    }

    var goalChart = new ApexCharts(
        document.querySelector("#perbandingan-piutang"),
        goalChartoptions
    );

    goalChart.render();
</script>
@endsection