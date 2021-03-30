<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur</title>
</head>

<body>
    <!-- Containter Pertama-->
    <div style="width: 90%; padding: 15px; margin-right: auto; margin-left: auto; border: 1px solid;">
        <h2 style="text-align: center;">FAKTUR</h2>
        <img src="/images/logo.png" style="margin-right: auto; margin-left: auto; display: block; margin-bottom: 20px; height: 100px; width: auto;"
            alt="logo obor">

        <!-- Containter Kedua -->
        <div style="width: 90%; padding: 15px; margin-right: auto; margin-left: auto;">

            <!-- Row Pertama-->
            <div style="display: flex; flex-wrap: wrap; margin-left: -15px; margin-right: -15px;">

                <!-- Kolom Kiri -->
                <div style="flex: 0 0 50%; max-width: 50%;">
                    <h4>
                        Jl. Plaju 10 Jakarta 10230, Indonesia <br>
                        Tlp. (021) 3920114, 31926978, 8751924 <br>
                        Fax. 31924488 <br>
                        email : yayasanobor@cbn.net.id <br>
                        <br>
                        Bank : <br>
                        BCA Cabang Penjernihan Jakarta <br>
                        No. Rekening : 1113000621 <br>
                        <br>
                        CIMB Niaga Cabang Thamrin <br>
                        No. Rekening : 005-01-01811-008
                    </h4>
                </div>

                <!-- Kolom Kanan -->
                <div style="flex: 0 0 50%; max-width: 50%;">
                    <h4 style="text-align: right;">
                        Kepada Yth. <br>
                        {{ $fakturone->returbeli->belibuku->supplier->nm_supplier }} <br>
                        {{ $fakturone->returbeli->belibuku->supplier->alamat }} <br>
                        {{ $fakturone->returbeli->belibuku->supplier->kelurahan->name }} {{ $fakturone->returbeli->belibuku->supplier->kecamatan->name }} <br>
                        {{ $fakturone->returbeli->belibuku->supplier->kota->name }} {{ $fakturone->returbeli->belibuku->supplier->kode_pos }} <br>
                        {{ $fakturone->returbeli->belibuku->supplier->telepon }}
                    </h4>
                </div>

            </div>
            <!-- Akhir Row Pertama -->

            <!-- Row Kedua -->
            <div style="display: flex; flex-wrap: wrap; margin-left: -15px; margin-right: -15px;">

                <table
                    style="border-collapse: collapse; width: 100%; margin-bottom: 1rem; color: #212529; margin-top: 30px;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">No. Faktur : {{ $fakturone->id_faktur_retur_pembelian }}</th>
                            <th style="text-align: right;">Tanggal Retur : {{ date('d M Y', strtotime($fakturone->returbeli->updated_at)) }}</th>
                        </tr>
                    </thead>
                </table>

                <table style="border-collapse: collapse; width: 100%; margin-bottom: 1rem; color: #212529;">
                    <thead>
                        <tr>
                            <th scope="col" style=" border: 1px solid">No</th>
                            <th scope="col" style=" border: 1px solid">ISBN</th>
                            <th scope="col" style=" border: 1px solid">Jumlah</th>
                            <th scope="col" style=" border: 1px solid">Judul Buku</th>
                            <th scope="col" style=" border: 1px solid">Harga Satuan</th>
                            <th scope="col" style=" border: 1px solid">Diskon</th>
                            <th scope="col" style=" border: 1px solid">Harga Akhir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $i = 1;
                            $sumqty = 0;
                            $sumharga = 0;
                        @endphp
                        @foreach($faktur as $data)
                        <tr style="text-align: center;">
                            <td scope="row" style=" border: 1px solid">{{ $i }}</td>
                            <td style="border: 1px solid">{{ $data->returbeli->belibuku->indukbuku->isbn }}</td>
                            <td style="border: 1px solid">{{ $data->returbeli->qty }}</td>
                            <td style="border: 1px solid">{{ $data->returbeli->belibuku->indukbuku->judul_buku }}</td>
                            <td style="border: 1px solid">Rp {{ number_format($data->returbeli->belibuku->harga_beli_satuan, 0, '', '.') }}</td>
                            <td style="border: 1px solid">{{ $data->returbeli->discount }}%</td>
                            <td style="text-align: right; border: 1px solid">Rp {{ number_format(($data->returbeli->qty * $data->returbeli->belibuku->harga_beli_satuan) - (($data->returbeli->qty * $data->returbeli->belibuku->harga_beli_satuan * $data->returbeli->discount) / 100), 0, '', '.') }}</td>
                        </tr>
                        @php 
                            $i++;
                            $sumqty += $data->returbeli->qty;
                            $sumharga += ($data->returbeli->qty * $data->returbeli->belibuku->harga_beli_satuan) - (($data->returbeli->qty * $data->returbeli->belibuku->harga_beli_satuan * $data->returbeli->discount) / 100);
                        @endphp
                        @endforeach

                        <tr style="text-align: center;">
                            <td colspan="2" style="border: 1px solid; font-weight: bold;">Jumlah
                                Total</td>
                            <td style="border: 1px solid; font-weight: bold;">{{ $sumqty }}</td>
                            <td colspan="3" style="text-align: center; border: 1px solid; font-weight: bold;">Total
                                Harga</td>
                            <td style="text-align: right; border: 1px solid; font-weight: bold;">Rp {{ number_format($sumharga, 0, '', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Akhir Row Kedua -->

            <!-- Row Ketiga -->
            <div style="display: flex; flex-wrap: wrap; margin-left: -15px; margin-right: -15px; margin-top: 50px;">

                <!-- Kolom kiri -->
                <div style="flex: 0 0 33.333333%; max-width: 33.333333; text-align: center;">
                    <h4 style="margin-bottom: 100px;">Yang Menerima</h4>
                    <h4>(_________________________)</h4>
                </div>

                <!-- Kolom Tengah -->
                <div style="flex: 0 0 33.333333%; max-width: 33.333333; text-align: center;">
                    <h4 style="margin-bottom: 100px;">Diperiksa Oleh</h4>
                    <h4>(_________________________)</h4>
                </div>

                <!-- Kolom Kanan -->
                <div style="flex: 0 0 33.333333%; max-width: 33.333333; text-align: center;">
                    <h4 style="margin-bottom: 100px;">Yang Menyerahkan</h4>
                    <h4>(_________________________)</h4>
                </div>

            </div>



        </div>
        <!-- Akhir Container Kedua -->

    </div>
    <!-- Akhir Container Pertama-->

    <script>
        history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
        window.addEventListener('popstate', function(event) {
            window.location.assign("/admin/inventori/retur-pembelian/list");
        });
    </script>
</body>

</html>