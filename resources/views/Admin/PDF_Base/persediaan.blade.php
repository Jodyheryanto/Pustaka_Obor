<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PERSEDIAAN BUKU</title>
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
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 75%; text-transform: uppercase; font-weight: bolder;">
                <h2>laporan persediaan buku</h2>
                <h4 style="margin-top: -10px;">pustaka obor indonesia</h4>
            </div>
            <!-- END: Column 1 -->

            <!-- START: Column 2 -->
            <div
                style="position: relative; width: 100%;padding-right: 15px;padding-left: 15px; flex-basis: 0; flex-grow: 1;max-width: 25%; ">
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
                        <th scope="col" style="background-color: #fff;">no</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">judul buku</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">stok awal</th>
                        <th scope="col" style="background-color: #fff;">pembelian</th>
                        <th scope="col" style="background-color: #fff;">penjualan</th>
                        <th scope="col" style="background-color: #fff;">retur pembelian</th>
                        <th scope="col" style="background-color: #fff;">retur penjualan</th>
                        <th scope="col" style="background-color: #fff;">terima / titip</th>
                        <th scope="col" style="background-color: #fff;">stok akhir</th>
                    </tr>
                </thead>
                <tbody style="text-transform: capitalize;">
                @php
                    $i = 1;
                    $sumbeli = 0;
                    $sumjual = 0;
                    $sumreturbeli = 0;
                    $sumreturjual = 0;
                    $sumkonsinyasi = 0;
                @endphp
                @foreach($indukbuku as $data)
                  @php
                    if($data->sumbeli != NULL){
                      $sumbeli = $data->sumbeli->qtybeli;
                    }else{
                      $sumbeli = 0;
                    }
                    if($data->sumjual != NULL){
                      $sumjual = $data->sumjual->qtyjual;
                    }else{
                      $sumjual = 0;
                    }
                    if($data->sumreturbeli != NULL){
                      $sumreturbeli = $data->sumreturbeli->qtyretur;
                    }else{
                      $sumreturbeli = 0;
                    }
                    if($data->sumreturjual != NULL){
                      $sumreturjual = $data->sumreturjual->qtyretur;
                    }else{
                      $sumreturjual = 0;
                    }
                    if($data->sumtitip != NULL && $data->sumterima != NULL){
                      $sumkonsinyasi = $data->sumtitip->qty - $data->sumterima->qty;
                    }elseif($data->sumtitip != NULL && $data->sumterima == NULL){
                      $sumkonsinyasi = $data->sumtitip->qty - 0;
                    }elseif($data->sumtitip == NULL && $data->sumterima != NULL){
                      $sumkonsinyasi = 0 - $data->sumterima->qty;
                    }else{
                      $sumkonsinyasi = 0;
                    }
                  @endphp
                  <tr>
                      <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff;">{{ $i }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $data->judul_buku }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $data->stock->qty - (($sumbeli - $sumreturbeli) - ($sumjual - $sumreturjual) + ($sumkonsinyasi)) }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $sumbeli }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $sumjual }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $sumreturbeli }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $sumreturjual }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $sumkonsinyasi }}
                      </td>
                      <td
                          style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                          {{ $data->stock->qty }}
                      </td>
                  </tr>
                  @php
                      $i++
                  @endphp
                  @endforeach
                </tbody>
            </table>
            <!-- END: Table -->
        </div>
        <!-- END: Row  3 (Data Table)-->

    </div>
    <!-- END: Container -->


    <script>
        history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
        window.addEventListener('popstate', function(event) {
            window.location.assign("/admin/inventori/induk-buku/list");
        });
    </script>
</body>

</html>