<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN KARTU STOK</title>
</head>

<style>
    @font-face {
        font-family: muli, sans-serif;
        src: url('Muli-VariableFont_wght.ttf') format('truetype');
    }
</style>

<body style="font-family: muli;">

    @foreach($indukbuku as $data1)
    @foreach($databuku as $data2)
    @if($data1->kode_buku == $data2['kode_buku'])
    <!-- START: Container -->
    <div
        style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto; width: 595px; min-height: 1000px; border: 1px solid black;">

        <!-- START: Row 1 -->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">

            <!-- START: Column 1 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%;">
                <h2 style="font-weight: bolder; text-transform: uppercase;">laporan kartu stok</h2>
                <h6>Judul Buku : {{ $data1->judul_buku }}</h6>
                <h6 style="margin-top: -20px;">ISBN : {{ $data1->isbn }}</h6>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; ">
                <img src="/images/logo.png" style="max-width: 57%; height: auto;  float: right !important;"
                    alt="">
            </div>
            <!-- END: Column 2 -->

        </div>
        <!-- END: Row 1 -->

        <hr
            style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; border-radius: 5px; margin-top: -15px;">

        <!-- START: Row 2 -->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;  font-size: .7rem;">

            <!-- START: Column 1 -->
            <div
                style="position: relative; padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 41.666667%;">
                <p>
                    Kepada : {{ $data1->pengarang->nm_pengarang }} <br>
                    Penerbit : {{ $data1->penerbit->nm_penerbit }} <br>
                    Tahun Terbit : {{ $data1->tahun_terbit }} <br>
                    Distributor : {{ $data1->distributor->nm_distributor }} <br>
                    @if($data1->penerjemah != NULL)
                    Penerjemah      : {{ $data1->penerjemah->nm_penerjemah }}
                    @else
                    Penerjemah      : -
                    @endif
                    Kategori : {{ $data1->kategori->nama }}
                </p>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 58.333333%;">
                <p style="text-transform: capitalize; font-weight: bolder;">deskripsi buku</p>
                <p>
                    {{ $data1->deskripsi_buku }}
                </p>
            </div>
            <!-- END: Column 2 -->
        </div>
        <!-- END: Row 2 -->


        <!-- START: Row  3 (Data Table)-->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">

            <h5 style="text-transform: uppercase; margin-left: 15px; margin-top: 2rem; margin-bottom: 2rem;">riwayat
                transaksi</h5>
            <!-- START: Table -->
            <table
                style="width: 100%;margin-bottom: 1rem;color: #212529; margin-bottom: 1.5rem; padding-right: 15px; padding-left: 15px; font-size: .6rem;">
                <thead style="display: table-header-group;">
                    <tr style="vertical-align: bottom; border-bottom: 1px solid #bbbbbb; text-transform: capitalize;">
                        <th scope="col" style="background-color: #fff;">no</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">tanggal & waktu</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">entitas</th>
                        <th scope="col" style="background-color: #fff;">stok awal</th>
                        <th scope="col" style="background-color: #fff;">barang masuk</th>
                        <th scope="col" style="background-color: #fff;">barang keluar</th>
                        <th scope="col" style="background-color: #fff;">stok akhir</th>
                    </tr>
                </thead>
                <tbody style="text-transform: capitalize;">
                @php
                    $i = 1;
                    $stokawal = 0;
                    $stoksebelum = 0;
                    $summasuk = 0;
                    $sumkeluar = 0;
                    $hapus = 0;
                    $awal = 0;
                @endphp
                @foreach($data1->histori as $data3)
                    @php
                        $split = preg_split('#(?<=[a-z])(?=\d)#i', $data3->id_transaksi);
                        $stokawal = $data1->histori[0]->stok_awal;
                        if($i == 1 && $data3->status == 1){
                            $stoksebelum = $data3->stok_awal;
                            $hapus = 1;
                            $awal = 1;
                        }elseif($i == 1 && $data3->status == 0){
                            $stokawal = $data3->stok_awal;
                        }
                        if($data3->status == 1 && $hapus == 0){
                            $stoksebelum = $data3->stok_awal;
                            $hapus = 1;
                        }
                    @endphp
                    <tr>
                        <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff;">{{ $i }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ date('d M Y h:m:s', strtotime($data3->created_at)) }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data3->entitas }} @if($data3->status == 1) - Dihapus @endif
                        </td>
                        @if($hapus == 1)
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $stoksebelum }}
                        </td>
                        @else
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data3->stok_awal }}
                        </td>
                        @endif
                        @if($split[0] == 'B' || $split[0] == 'RJ' || $split[0] == 'FKP')
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data3->qty }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            0
                        </td>
                        @else
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            0
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data3->qty }}
                        </td>
                        @endif
                        @if($split[0] == 'B' || $split[0] == 'RJ' || $split[0] == 'FKP')
                            @if($hapus == 1 && $data3->status == 0)
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $stoksebelum + $data3->qty }}
                            </td>
                            @php
                                $stoksebelum = $stoksebelum + $data3->qty;
                            @endphp
                            @elseif($hapus == 1 && $data3->status == 1)
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $stoksebelum }}
                            </td>
                            @else
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data3->stok_awal + $data3->qty }}
                            </td>
                            @endif
                        @else
                            @if($hapus == 1 && $data3->status == 0)
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $stoksebelum - $data3->qty }}
                            </td>
                            @php
                                $stoksebelum = $stoksebelum - $data3->qty;
                            @endphp
                            @elseif($hapus == 1 && $data3->status == 1)
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $stoksebelum }}
                            </td>
                            @else
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data3->stok_awal - $data3->qty }}
                            </td>
                            @endif
                        @endif
                    </tr>
                    @php
                        $i++;
                        if(($split[0] == 'B' || $split[0] == 'RJ' || $split[0] == 'FKP') && ($data3->status == 0)){
                            $summasuk += (int) $data3->qty;
                        }elseif(($split[0] == 'J' || $split[0] == 'RB' || $split[0] == 'FKT') && ($data3->status == 0)){
                            $sumkeluar += (int) $data3->qty;
                        }
                    @endphp
                @endforeach
                <tr>
                    <th scope="row" colspan="4">Jumlah</th>
                    <th>{{ $summasuk }}</th>
                    <th>{{ $sumkeluar }}</th>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <th scope="row">Stok Awal : </th>
                    <th>{{ $stokawal }}</th>
                    <td></td>
                    <th scope="row">Stok Akhir : </th>
                    <th>{{ $data1->stock->qty }}</th>
                </tr>
                </tbody>
            </table>
            <!-- END: Table -->
        </div>
        <!-- END: Row  3 (Data Table)-->

    </div>
    <!-- END: Container -->
    @endif
    @endforeach
    @endforeach

    <script>
        history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
        window.addEventListener('popstate', function(event) {
            window.location.assign("/admin/inventori/induk-buku/list");
        });
    </script>
</body>

</html>