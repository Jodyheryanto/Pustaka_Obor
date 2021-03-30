@extends('layouts.base_user')

@section('title', 'List Royalti & Penjualan')

@section('content')
    <!-- START: Search Bar -->
    <nav class="navbar navbar-light bg-white justify-content-between">
        <div class="container">
            <div class="d-none d-sm-block">
                <a href="{{ route('user.index') }}" class="navbar-brand">
                    <img src="/user-assets/img/logo.png" alt="Logo PT Pustaka Obor Indonesia"
                        style="height: 80px; width: auto;">
                </a>
            </div>
            <form class="form-inline" action="{{ route('user.list-buku') }}" method="POST">
                {{csrf_field()}}
                <input class="form-control mr-sm-2" type="search" placeholder="Masukkan NIK penulis buku lain" name="nik" aria-label="Search">
                <button class="btn my-2 my-sm-0 btn-search" type="submit">Cari</button>
            </form>
        </div>
    </nav>
    <!-- END: Search Bar -->

    <!-- START: List of Books -->
    <div class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4 accordion mt-2" id="accordionExample">
                    <div class="card">
                        <div class="w-100 box-shadow p-3 bg-white mt-4 d-flex justify-content-start">
                            <div class="w-100">
                                <img src="/laravel/storage/app/public/{{ $indukbuku->cover }}" class="float-left mr-3 cover" style="height: 100px; width: auto;" alt="Buku Penulis">
                                <p class="ISBN">#{{ $indukbuku->isbn }}</p>
                                <h4 class="judul-buku">{{ $indukbuku->judul_buku }}</h4>
                                <p class="font-italic penulis">{{ $indukbuku->pengarang->nm_pengarang }}</p>
                            </div>
                            <!-- <a href="" style="margin-left: auto;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><img src="/user-assets/design/arrow.svg" alt="black arrow"></a> -->
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <!-- begin invoice-header -->
                                <div class="invoice-header">
                                    <div class="invoice-from">
                                        <small>Detail Buku</small>
                                        <address class="m-t-5 m-b-5">
                                            Tahun Terbit : {{ $indukbuku->tahun_terbit }}<br>
                                            Penerbit : {{ $indukbuku->penerbit->nm_penerbit }}<br>
                                            Distributor : {{ $indukbuku->distributor->nm_distributor }}<br>
                                            Deskripsi : {{ $indukbuku->deskripsi_buku }}<br>
                                        </address>
                                    </div>
                                    <div class="invoice-date">
                                        <small>Invoice / {{ date('d M Y') }}</small>
                                        <div class="date text-inverse m-t-5">{{ date('d M Y') }}</div>
                                        <div class="invoice-detail">
                                            Pembayaran Royalti
                                        </div>
                                    </div>
                                </div>
                                <!-- end invoice-header -->
                                <!-- begin invoice-content -->
                                <div class="invoice-content">
                                    <!-- begin table-responsive -->
                                    <div class="table-responsive">
                                    <table class="table table-invoice">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Pembeli</th>
                                                <th class="text-center">Harga Satuan</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Harga Total</th>
                                                <th class="text-center">Royalti ({{ $indukbuku->pengarang->persen_royalti }}% Penjualan)</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $pajak = 0;
                                            $sumharga = 0;
                                        @endphp
                                        <tbody>
                                            @foreach($indukbuku->jualdetail as $data)
                                            <tr>
                                                <td class="text-center">
                                                    <span class="text-inverse">{{ $data->pelanggan->nama }}</span>
                                                </td>
                                                <td class="text-center">Rp. {{ $data->harga_jual_satuan }}</td>
                                                @if($data->returroyalti == NULL)
                                                <td class="text-center">{{ $data->qty }}</td>
                                                @else
                                                <td class="text-center">{{ $data->qty }} ({{ $data->returroyalti->qtyretur }})</td>
                                                @endif
                                                @if($data->returroyalti == NULL)
                                                <td class="text-center">Rp. {{ number_format( $data->total_non_diskon, 0, '', '.') }}</td>
                                                @else
                                                <td class="text-center">Rp. {{ number_format($data->total_non_diskon -  $data->returroyalti->total_non_diskon, 0, '', '.') }}</td>
                                                @endif
                                                @if($data->returroyalti == NULL)
                                                <td class="text-center">Rp. {{ number_format(($data->total_non_diskon * $indukbuku->pengarang->persen_royalti) / 100, 0, '', '.') }}</td>
                                                @else
                                                <td class="text-center">Rp. {{ number_format((($data->total_non_diskon -  $data->returroyalti->total_non_diskon) * $indukbuku->pengarang->persen_royalti) / 100, 0, '', '.') }}</td>
                                                @endif
                                            </tr>
                                            @php 
                                                if($data->returroyalti == NULL){
                                                    $sumharga += ($data->total_non_diskon * $indukbuku->pengarang->persen_royalti) / 100;
                                                }else{
                                                    $sumharga += (($data->total_non_diskon -  $data->returroyalti->total_non_diskon) * $indukbuku->pengarang->persen_royalti) / 100;
                                                }
                                                if($indukbuku->pengarang->NPWP != NULL){
                                                    $pajak += 0;
                                                }else{
                                                    if($data->returroyalti == NULL){
                                                        $pajak += ((($data->total_non_diskon * $indukbuku->pengarang->persen_royalti) / 100) * 15) / 100;
                                                    }else{
                                                        $pajak += (((($data->total_non_diskon -  $data->returroyalti->total_non_diskon) * $indukbuku->pengarang->persen_royalti) / 100) * 15) / 100;
                                                    }
                                                }
                                            @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    <!-- end table-responsive -->
                                    <!-- begin invoice-price -->
                                    <div class="invoice-price">
                                    <div class="invoice-price-left">
                                        <div class="invoice-price-row">
                                            <div class="sub-price">
                                                <small>JUMLAH ROYALTI</small>
                                                <span class="text-inverse">Rp. {{ number_format( $sumharga, 0, '', '.') }}</span>
                                            </div>
                                            <div class="sub-price">
                                                <i class="fa fa-plus text-muted"></i>
                                            </div>
                                            @if($indukbuku->pengarang->NPWP != NULL)
                                            <div class="sub-price">
                                                <small>PAJAK (0%)</small>
                                                <span class="text-inverse">Rp. 0</span>
                                            </div>
                                            @else
                                            <div class="sub-price">
                                                <small>PAJAK (15%)</small>
                                                <span class="text-inverse">Rp. {{ number_format( $pajak , 0, '', '.') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="invoice-price-right">
                                        <small>TOTAL ROYALTI (Bersih)</small> <span class="f-w-600">Rp. {{ number_format( $sumharga - $pajak , 0, '', '.') }}</span>
                                    </div>
                                    </div>
                                    <!-- end invoice-price -->
                                </div>
                                <!-- end invoice-content -->
                                <!-- begin invoice-footer -->
                                <div class="invoice-footer">
                                    <p class="text-center m-b-5 f-w-600">
                                    DATA ROYALTI<br>
                                    THANK YOU FOR YOUR HARD WORK
                                    </p>
                                    <p class="text-center">
                                    <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i>By Pustaka Obor Indonesia</span>
                                    </p>
                                </div>
                                <!-- end invoice-footer -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="container d-flex justify-content-end mt-4">
                    <div class="form-row">
                        <div class="col">
                            <input placeholder="Tanggal Awal" type="text" class="form-control datepicker" id="tgl_awal">
                        </div>
                        <div class="col">
                            <input placeholder="Tanggal Akhir" type="text" class="form-control datepicker" id="tgl_akhir">
                        </div>
                    </div>
                </div> -->

                <!-- Grafik -->
                <!-- <div class="container">
                    <figure class="highcharts-figure box-shadow">
                        <div id="grafik"></div>
                    </figure>
                </div>  -->
            </div>
        </div>
    </div>
    <!-- END: List of Books -->
@endsection
@section('page-js')
<script>
    $(function () {
        $("#tgl_awal, #tgl_akhir").datepicker();
    });
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    Highcharts.theme = {
        colors: ['#2ED47A', '#333333', '#ED561B', '#DDDF00', '#24CBE5', '#64E572',
            '#FF9655', '#FFF263', '#6AF9C4'],
        title: {
            style: {
                color: '#000',
                font: 'bold 16px "Gilroy-Bold" '
            }
        }
    };
    // Apply the theme
    Highcharts.setOptions(Highcharts.theme);

    Highcharts.chart('grafik', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Laporan Penjualan'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
        },
        xAxis: {
            categories: [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ],
        },
        yAxis: {
            title: {
                text: 'Pendapatan'
            },
            labels: {
                formatter: function () {
                    return this.value + ' Juta'
                }
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' units'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Sebuah Seni Untuk Bersikap Bodo Amat',
            data: [3, 4, 3, 5, 4, 10, 12]
        }, {
            name: 'Segala-galanya Ambyar',
            data: [1, 3, 4, 3, 3, 5, 4],
        }
        ]
    });
</script>
@endsection