<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Konsinyasi @if(str_contains($fakturone->id_faktur_konsinyasi, 'FKTKNSR') == true) (Retur) @endif</title>
</head>

<style>
    @font-face {
        font-family: muli, sans-serif;
        src: url('Muli-VariableFont_wght.ttf') format('truetype');
    }
</style>

<body style="font-family: muli;">

    <!-- Untuk penitip -->
    <!-- START: Container -->
    <div
        style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto; width: 595px; height: 1000px; border: 1px solid black;">

        <!-- START: Row 1 -->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">

            <!-- START: Column 1 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%;">
                <h2 style="font-weight: bolder; text-transform: uppercase;">Faktur Konsinyasi @if(str_contains($fakturone->id_faktur_konsinyasi, 'FKTKNSR') == true) (Retur) @endif</h2>
                <h5>No. Faktur : {{ $fakturone->id_faktur_konsinyasi }}</h5>
                <h5 style="margin-top: -15px;">Tanggal Faktur : {{ date('d M Y') }}</h5>
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
                <p>Kepada</p>
                <p style="font-weight: bolder; margin-top: -10px;">Yth {{ $fakturone->pelanggan->nama }}</p>
                <p>
                    {{ $fakturone->pelanggan->alamat }} <br>
                    {{ $fakturone->pelanggan->kelurahan->name }} {{ $fakturone->pelanggan->kecamatan->name }} <br>
                    {{ $fakturone->pelanggan->kota->name }} {{ $fakturone->pelanggan->kode_pos }} <br>
                    {{ $fakturone->pelanggan->telepon }}
                </p>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 41.666667%;">
                <p>Dari</p>
                <p style="font-weight: bolder; margin-top: -10px;">Pustaka Obor Indonesia</p>
                <p>
                    Jl. Plaju 10 Jakarta 10230, Indonesia <br>
                    Tlp. (021) 3920114, 31926978, 8751924 <br>
                    Fax. 31924488 <br>
                    email : yayasanobor@cbn.net.id
                </p>
                <p>
                    BCA Cabang Penjernihan Jakarta <br>
                    No. Rekening : 1113000621 <br>
                    CIMB Niaga Cabang Thamrin <br>
                    No. Rekening : 005 01 01811 008
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
                        <th scope="col" style="background-color: #fff">Diskon</th>
                        <th scope="col" style="background-color: #fff">Harga Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = 1;
                        $sumqty = 0;
                        $sumharga = 0;
                    @endphp
                    @foreach($faktur as $data)
                    <tr>
                        <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff">{{ $i }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->indukbuku->isbn }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->qty }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->indukbuku->judul_buku }} @if($data->indukbuku->is_obral == 1) (Obral) @endif</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format($data->harga_satuan, 0, '', '.') }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->discount }}%</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format($data->harga_total, 0, '', '.') }}</td>
                    </tr>
                    @php 
                        $i++;
                        $sumqty += $data->qty;
                        $sumharga += $data->harga_total;
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
                        <td colspan="3"
                            style="padding: 0.75rem;vertical-align: top; background-color: #fff; border-top: 1px solid #bbbbbb; text-align: end;">
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

        <!-- START: Row 4 (Tanda Tangan) -->
        <div
            style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;  font-size: .6rem; font-weight: bold; text-transform: uppercase; margin-top: 1.5rem;">

            <!-- START: Yang Menerima -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 5rem;">yang menerima</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: Yang Menerima -->

            <!-- START: DIperiksa Oleh -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 5rem;">diperiksa oleh</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: DIperiksa Oleh -->

            <!-- START: Yang Menyerahkan -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 5rem;">yang menitip</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: Yang Menyerahkan -->

        </div>
        <!-- END: Row 4 (Tanda Tangan) -->

    </div>
    <!-- END: Container -->

    <!-- Untuk penerima -->
    <!-- START: Container -->
    <div
        style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-top: 40px;margin-left: auto; width: 595px; height: 1000px; border: 1px solid black;">

        <!-- START: Row 1 -->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">

            <!-- START: Column 1 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%;">
                <h2 style="font-weight: bolder; text-transform: uppercase;">Faktur Konsinyasi @if(str_contains($fakturone->id_faktur_konsinyasi, 'FKTKNSR') == true) (Retur) @endif</h2>
                <h5>No. Faktur : {{ $fakturone->id_faktur_konsinyasi }}</h5>
                <h5 style="margin-top: -15px;">Tanggal Faktur : {{ date('d M Y') }}</h5>
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
                <p>Kepada</p>
                <p style="font-weight: bolder; margin-top: -10px;">Pustaka Obor Indonesia</p>
                <p>
                    Jl. Plaju 10 Jakarta 10230, Indonesia <br>
                    Tlp. (021) 3920114, 31926978, 8751924 <br>
                    Fax. 31924488 <br>
                    email : yayasanobor@cbn.net.id
                </p>
                <p>
                    BCA Cabang Penjernihan Jakarta <br>
                    No. Rekening : 1113000621 <br>
                    CIMB Niaga Cabang Thamrin <br>
                    No. Rekening : 005 01 01811 008
                </p>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 41.666667%;">
                <p>Dari</p>
                <p style="font-weight: bolder; margin-top: -10px;">Yth {{ $fakturone->pelanggan->nama }}</p>
                <p>
                    {{ $fakturone->pelanggan->alamat }} <br>
                    {{ $fakturone->pelanggan->kelurahan->name }} {{ $fakturone->pelanggan->kecamatan->name }} <br>
                    {{ $fakturone->pelanggan->kota->name }} {{ $fakturone->pelanggan->kode_pos }} <br>
                    {{ $fakturone->pelanggan->telepon }}
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
                        <th scope="col" style="background-color: #fff">Diskon</th>
                        <th scope="col" style="background-color: #fff">Harga Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = 1;
                        $sumqty = 0;
                        $sumharga = 0;
                    @endphp
                    @foreach($faktur as $data)
                    <tr>
                        <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff">{{ $i }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->indukbuku->isbn }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->qty }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->indukbuku->judul_buku }} @if($data->indukbuku->is_obral == 1) (Obral) @endif</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format($data->harga_satuan, 0, '', '.') }}</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            {{ $data->discount }}%</td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff">
                            Rp {{ number_format($data->harga_total, 0, '', '.') }}</td>
                    </tr>
                    @php 
                        $i++;
                        $sumqty += $data->qty;
                        $sumharga += $data->harga_total;
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
                        <td colspan="3"
                            style="padding: 0.75rem;vertical-align: top; background-color: #fff; border-top: 1px solid #bbbbbb; text-align: end;">
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

        <!-- START: Row 4 (Tanda Tangan) -->
        <div
            style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;  font-size: .6rem; font-weight: bold; text-transform: uppercase; margin-top: 1.5rem;">

            <!-- START: Yang Menerima -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 5rem;">yang menerima</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: Yang Menerima -->

            <!-- START: DIperiksa Oleh -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 5rem;">diperiksa oleh</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: DIperiksa Oleh -->

            <!-- START: Yang Menyerahkan -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 100%; text-align: center;">
                <h4 style="margin-bottom: 5rem;">yang menitip</h4>
                <hr
                    style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; width: 75%; border-radius: 5px;">
            </div>
            <!-- END: Yang Menyerahkan -->

        </div>
        <!-- END: Row 4 (Tanda Tangan) -->

    </div>
    <!-- END: Container -->

    <script>
        history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
        window.addEventListener('popstate', function(event) {
            window.location.assign("/faktur/konsinyasi/list");
        });
    </script>
</body>

</html>