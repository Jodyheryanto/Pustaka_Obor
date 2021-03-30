<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN ROYALTI</title>
</head>

<style>
    @font-face {
        font-family: muli, sans-serif;
        src: url('Muli-VariableFont_wght.ttf') format('truetype');
    }
</style>

<body style="font-family: muli;">
    @foreach($datajual as $jual)
    @foreach($pengarang as $data)
    @if(count($data->indukbuku) != 0 && $jual['id_pengarang'] == $data->id_pengarang)

    <!-- START: Container -->
    <div
        style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto; width: 595px; height: 1000px; border: 1px solid black;">

        <!-- START: Row 1 -->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">

            <!-- START: Column 1 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%;">
                <h2 style="text-transform: uppercase;">laporan royalti </h2>
                <h5 style="font-weight: bolder;">{{ date('d M Y', strtotime(session('tgl_mulai'))) }} s/d {{ date('d M Y', strtotime(session('tgl_selesai'))) }}</h5>
                <h5 style="margin-top: -15px;">Formulir Perintah Bayar</h5>
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
                style="position: relative; padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 58.333333%;">
                <p style="font-weight: bolder;">Yth {{ $data->nm_pengarang }}</p>
                <p>
                    Jl. Suka Damai No.69 <br> KEBUTUH, BUKATEJA <br>
                    KABUPATEN PURBALINGGA <br>
                    53382
                </p>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 41.666667%;">
                <p>
                    Nama : {{ $data->nm_pengarang }} <br>
                    Alamat : {{ $data->alamat }} 
                    @if($data->tb_negara_id === 101)
                    <br> {{ $data->kelurahan->name }} {{ $data->kecamatan->name }}
                    <br>{{ $data->kota->name }} {{ $data->kode_pos }}
                    @endif
                    email : {{ $data->email }}
                </p>
            </div>
            <!-- END: Column 2 -->
        </div>
        <!-- END: Row 2 -->

        <!-- START: Row  3 (Data Table)-->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; font-size: .6rem;">

            <!-- START: Table -->
            <table
                style="width: 100%;margin-bottom: 1rem;color: #212529; margin-top: 1.5rem; margin-bottom: 1.5rem; padding-right: 15px; padding-left: 15px;">
                <thead style="display: table-header-group;">
                    <tr style="vertical-align: bottom; border-bottom: 1px solid #bbbbbb;">
                        <th scope="col" style="background-color: #fff">No</th>
                        <th scope="col" style="background-color: #fff">No ISBN</th>
                        <th scope="col" style="background-color: #fff">Jumlah</th>
                        <th scope="col" style="background-color: #fff">Judul Buku</th>
                        <th scope="col" style="background-color: #fff">Harga Satuan</th>
                        <th scope="col" style="background-color: #fff">Total Harga</th>
                        <th scope="col" style="background-color: #fff">Royalty {{ $data->persen_royalti }}%</th>
                        <th scope="col" style="background-color: #fff">PPH 15%</th>
                        <th scope="col" style="background-color: #fff">Total Royalty</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                    $sumqty = 0;
                    $sumharga = 0;
                @endphp
                @foreach($data->indukbuku as $data2)
                    @if(count($data2->jualdetail) > 0)
                    @php
                        $hargatotal = 0;
                        $qtytotal = 0;
                        $qtyjual = 0;
                        $qtyretur = 0;
                        foreach($data2->jualdetail as $data3){
                            if($data3->returroyalti != NULL){
                                $hargatotal += $data3->total_non_diskon -  $data3->returroyalti->total_non_diskon;
                                $qtytotal += $data3->qty -  $data3->returroyalti->qtyretur;
                                $qtyjual += $data3->qty;
                                $qtyretur += $data3->returroyalti->qtyretur;
                            }else{
                                $hargatotal += $data3->total_non_diskon;
                                $qtytotal += $data3->qty;
                                $qtyjual += $data3->qty;
                            }
                        }
                    @endphp
                    <tr>
                        <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff">{{ $i }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data2->isbn }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $qtyjual }} ({{$qtyretur}})</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data2->judul_buku }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format($data2->harga_jual, 0, '', '.') }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format(($hargatotal), 0, '', '.') }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format(($hargatotal * $data->persen_royalti) / 100, 0, '', '.') }}</td>
                        @if($data->NPWP == '')
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format(((($hargatotal * $data->persen_royalti) / 100) * 15) / 100, 0, '', '.') }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format((($hargatotal * $data->persen_royalti) / 100) - (((($hargatotal * $data->persen_royalti) / 100) * 15) / 100), 0, '', '.') }}</td>
                        @else
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp 0</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format(((($hargatotal) * $data->persen_royalti) / 100), 0, '', '.') }}</td>
                        @endif
                    </tr>
                    @php 
                        $sumqty = $data2->jualbukuadmin->qtyjual - $data2->jualbukuadmin->qtyretur;
                        if($data->NPWP == ''){
                            $sumharga += (($hargatotal * $data->persen_royalti) / 100) - (((($hargatotal * $data->persen_royalti) / 100) * 15) / 100);
                        }else{
                            $sumharga += ($hargatotal * $data->persen_royalti) / 100;
                        }
                    @endphp
                    @endif
                    @php
                        $i++;
                    @endphp
                @endforeach
                    <tr style="font-weight: bold;">
                        <td colspan="2"
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Total Buku
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $sumqty }}</td>
                        <td colspan="5"
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff; text-align: end;">
                            Total Harga</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format($sumharga, 0, '', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- END: Table -->
        </div>
        <!-- END: Row  3 (Data Table)-->


        <!-- START: Row 4 (Perintah Pembayaran) -->
        <div
            style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;  font-size: .6rem; font-weight: bold; margin-top: -1rem;">

            <!-- START: Content Perintah Bayar-->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%;">
                <h4 style="font-weight: bolder; text-transform: uppercase;">perintah pembayaran</h4>
                <p style="font-size: 0.6rem;">
                    Untuk pembayaran royalty diatas, saya memilih alternatif berikut : <br>
                    (. . . .) Saya akan mengambil sendiri ke kantor Yayasan Pustaka Obor Indonesia, pada tanggal . . . . . . . . . . . . . <br>
                    (harap konfirmasi terlebih dahulu) <br>
                    (. . . .) Mohon dikirim ke rekening Bank . . . . . . . . . . Nomor . . . . . . . . . . a/n . . . . . . . . . . . . . . <br>
                    (. . . .) Lain-lain / dikuasakan (dengan membawa surat kuasa)</p>
            </div>
            <!-- END: Content Perintah Bayar-->

        </div>
        <!-- END: Row 4 (Perintah Pembayaran) -->

        <!-- START: Row 5 (Tanda Tangan) -->
        <div
            style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;  font-size: .6rem; font-weight: bold; text-transform: uppercase; margin-top: 1.5rem;">

            <!-- START: Pemilik Naskah / Penerima -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 4rem;">pemilik naskah / penerima</h4>
                <p>({{ $data->nm_pengarang }})</p>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: Pemilik Naskah / Penerima -->

            <!-- START: Yang Menyerahkan -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <p style="text-transform: capitalize ">Jakarta, {{ date('d M Y') }}</p>
                <h4 style="margin-bottom: 4rem;">bagian administrasi</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <p style="padding-right: 15px;padding-left: 15px; font-size: 0.5rem;">NB : Setelah ditandatangani, formulir Perintah Pembayaran ini harap dikirim ke Yayasan Pustaka Obor Indonesia</p>
            <!-- END: Yang Menyerahkan -->

        </div>
        <!-- END: Row 5 (Tanda Tangan) -->

    </div>
    <!-- END: Container -->
    @endif
    @endforeach
    @endforeach

    <script>
        history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
        window.addEventListener('popstate', function(event) {
            window.location.assign("/admin/master/pengarang/list");
        });
    </script>
</body>

</html>