<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN ANALISA PELANGGAN</title>
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
                <h3>laporan analisa pelanggan</h3>
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
                        <th scope="col" style="background-color: #fff; text-align: start;">id pelanggan</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">nama pelanggan</th>
                        <th scope="col" style="background-color: #fff; text-align: start;">qty terjual</th>
                    </tr>
                </thead>
                <tbody style="text-transform: capitalize;">
                  @php
                    $i = 1;
                    $sumqty = 0;
                  @endphp
                  @foreach($pelanggan as $data)
                    @if($data->jualbuku !== NULL)
                    <tr>
                        <td style="vertical-align: middle; border-top: 1px solid #bbbbbb; background-color: #fff;">{{ $i }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data->id_pelanggan }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data->nama }}
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $data->jualbuku->qtyjual }}
                        </td>
                    </tr>
                    @endif
                    @php
                        $i++;
                        if($data->jualbuku != NULL){
                          $sumqty += $data->jualbuku->qtyjual;
                        }else{
                          $sumqty += 0;
                        }
                    @endphp
                    @endforeach
                    <tr style="font-weight: bold; text-transform: capitalize; font-weight: bolder;">
                        <td colspan="3"
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            jumlah
                        </td>
                        <td
                            style="padding: 0.75rem;vertical-align: top; border-top: 1px solid #bbbbbb; background-color: #fff;">
                            {{ $sumqty }}
                        </td>
                    </tr>
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
            window.location.assign("/admin/master/pelanggan/list");
        });
    </script>
</body>

</html>