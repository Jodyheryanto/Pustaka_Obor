<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN ANALISA PEMBELIAN BUKU</title>
</head>

<style>
    @font-face {
        font-family: muli, sans-serif;
        src: url('Muli-VariableFont_wght.ttf') format('truetype');
    }
</style>

<body style="font-family: muli;">

    <!-- START: Container -->
    <div
        style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto; width: 595px; height: 1000px; border: 1px solid black;">

        <!-- START: Row 1 -->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">

            <!-- START: Column 1 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 66.666667%;text-transform: uppercase; font-weight: bolder;">
                <h3>analisa beli buku by
                @if($kode == 0)
                (QTY)
                @elseif($kode == 1)
                (Nilai Beli)
                @elseif($kode == 2)
                (Supplier)
                @endif
                </h3>
                <h5 style="margin-top: -10px;">pustaka obor indonesia</h5>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 33.333333%; ">
                <img src="/images/logo.png" style="max-width: 57%; height: auto;  float: right !important;"
                    alt="">
            </div>
            <!-- END: Column 2 -->

        </div>
        <!-- END: Row 1 -->

        <hr
            style="box-sizing: content-box;height: 0; overflow: visible; border: 1px solid #bbbbbb; border-radius: 5px; margin-top: -15px;">


        <!-- START: Row  3 (Data Table)-->
        <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; margin-top: 3rem;">

            <!-- START: Table -->
            <table
                style="width: 100%;margin-bottom: 1rem;color: #212529; margin-bottom: 1.5rem; padding-right: 15px; padding-left: 15px; font-size: .6rem;">
                <thead style="display: table-header-group;">
                    <tr style="vertical-align: bottom; border-bottom: 1px solid #bbbbbb; text-transform: capitalize;">
                        <th scope="col" style="background-color: #fff; text-align: start;">no</th>
                        @if($kode == 0 || $kode == 1)
                        <th scope="col" style="background-color: #fff; text-align: start;">Kode Buku</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">Judul Buku</th>
                        @elseif($kode == 2)
                        <th scope="col" style="background-color: #fff; text-align: start;">ID Supplier</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">Nama Supplier</th>
                        @endif
                        @if($kode == 0)
                        <th scope="col" style="background-color: #fff; text-align: start;">Qty Terbeli</th>
                        @elseif($kode == 2)
                        <th scope="col" style="background-color: #fff; text-align: start;">Qty Terbeli</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">Nilai Beli</th>
                        @else
                        <th scope="col" style="background-color: #fff; text-align: start;">Nilai Beli</th>
                        @endif
                    </tr>
                </thead>
                <tbody style="text-transform: capitalize;">
                  @php
                    $i = 1;
                    $sum = 0;
                    $sumqty = 0;
                  @endphp
                  @foreach($arrBuku as $data)
                    @if($kode == 0)
                        <tr>
                            <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff;">{{ $i }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['kode_buku'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['judul_buku'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['qtybeli'] }}
                            </td>
                        </tr>
                    @elseif($kode == 1)
                        <tr>
                            <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff;">{{ $i }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['kode_buku'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['judul_buku'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                Rp. {{ number_format($data['nilaibeli'], 0, '', '.') }}
                            </td>
                        </tr>
                    @elseif($kode == 2)
                        <tr>
                            <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff;">{{ $i }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['id_supplier'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['nm_supplier'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                {{ $data['qtybeli'] }}
                            </td>
                            <td
                                style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                                Rp. {{ number_format($data['nilaibeli'], 0, '', '.') }}
                            </td>
                        </tr>
                    @endif
                    @php
                        $i++;
                        if($kode == 0){
                            $sum += $data['qtybeli'];
                        }else{
                            if(!empty($data['qtybeli'])){
                                $sumqty += $data['qtybeli'];
                            }
                            $sum += $data['nilaibeli'];
                        }
                    @endphp
                    @endforeach
                    <tr style="font-weight: bold; text-transform: capitalize; font-weight: bolder;">
                        <td colspan="3"
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            jumlah
                        </td>
                        @if($kode == 2 || $kode == 3)
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $sumqty }}
                        </td>
                        @endif
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            @if($kode == 0)
                            {{ $sum }}
                            @else
                            Rp. {{ number_format($sum, 0, '', '.') }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- END: Table -->
        </div>
        <!-- END: Row  3 (Data Table)-->

    </div>
    <!-- END: Container -->

</body>

</html>