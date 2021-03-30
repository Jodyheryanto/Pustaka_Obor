@extends('layouts.base_website')

@section('title', 'Cek Ongkos Kirim')
@section('jualbuku', true)

@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- Form wizard with step validation section start -->
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Cek Ongkos Kirim</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-title"><strong class="text-danger">Warning !</strong> Masukkan jenis pengiriman yang digunakan untuk mengecek ongkos kirim barang sebelum mencetak faktur.</p>
                            <form class="form-horizontal" action="{{ route('admin.inventori.penjualan-buku.cekOngkir') }}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="id_faktur" class="form-control required" value="{{ $fakturone->id_faktur_penjualan }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Info Faktur</label>
                                            <input type="text" class="form-control required" value="{{ $fakturone->id_faktur_penjualan }} - {{ $fakturone->jualbuku->pelanggan->nama }} - {{ date( 'd M Y', strtotime($fakturone->jualbuku->created_at)) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Berat Barang</label>
                                            <div class="controls">
                                                <input type="hidden" id="berat_total" name="berat_total" value="{{ $berat_total }}">
                                                <div class="input-group">
                                                    <input type="text" class="form-control required" value="{{ floatval($berat_total / 1000) }}" disabled>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">KG</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Pengiriman</label>
                                            <select class="select2 form-control required" data-validation-required-message="Jenis Pengiriman wajib dipilih" id="jenis_pengiriman" name="jenis_pengiriman">
                                                <option value="">-- Pilih Jenis Pengiriman --</option>
                                                <option value="tanpakirim">Ambil Sendiri</option>
                                                <option value="ojol">Grab / Gojek</option>
                                                <option value="jneyes">JNE City Courier - Yakin Esok Sampai</option>
                                                <option value="jnereg">JNE City Courier - Reguler</option>
                                                <option value="jneoke">JNE - Ongkos Kirim Ekonomis</option>
                                                <option value="jneregb">JNE - Layanan Reguler</option>
                                                <option value="pospkk">POS - Paket Kilat Khusus</option>
                                                <option value="posq9">POS - Q9 Barang</option>
                                                <option value="posex">POS - Express Next Day Barang</option>
                                                <option value="tikieco">TIKI - Economy Service</option>
                                                <option value="tikireg">TIKI - Regular Service</option>
                                                <option value="tikions">TIKI - Over Night Service</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alamat Asal</label>
                                            <input type="hidden" name="id_kota_asal" value="152">
                                            <select class="select2 form-control" id="kota_asal" disabled>
                                                @foreach($kota as $data)
                                                <option value="{{ $data['city_id'] }}" @php if($data['city_id'] == 152) echo 'selected' @endphp>{{ $data['type'] }} {{ $data['city_name'] }} ({{ $data['postal_code'] }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alamat Tujuan</label>
                                            <select class="select2 form-control" id="kota_tujuan" name="id_kota_tujuan">
                                                <option value="">-- Pilih Tujuan Pengiriman --</option>
                                                @foreach($kota as $data)
                                                <option value="{{ $data['city_id'] }}">{{ $data['type'] }} {{ $data['city_name'] }} ({{ $data['postal_code'] }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Ongkos Kirim 
                                            <!-- Image loader -->
                                            <span id='loader' style='display: none;'>
                                            <img src='/images/reload.gif' width='15px' height='15px'>
                                            </span>
                                            <!-- Image loader --></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input type="hidden" id="total_ongkir" name="total_ongkir" class="form-control" disabled>
                                                <input type="text" id="total_ongkir_act" name="total_ongkir" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estimasi Sampai <!-- Image loader -->
                                            <span id='loader2' style='display: none;'>
                                            <img src='/images/reload.gif' width='15px' height='15px'>
                                            </span>
                                            <!-- Image loader --></label>
                                            <div class="input-group">
                                                <input type="text" id="est_sampai" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Form wizard with step validation section end -->
@endsection
@section('page-js')
    <script>
    $(function () {
        $('#kota_tujuan').on('change', function () {
            var formatter = new Intl.NumberFormat('id-ID');
            if($('#jenis_pengiriman').val() != ''){
                if($('#jenis_pengiriman').val() == 'tanpakirim'){
                    $('#total_ongkir_act').val('').prop('disabled', true);
                    $('#total_ongkir').val('').prop('disabled', false);
                    $('#total_ongkir_act').val(0);
                    $('#total_ongkir').val(0);
                    $('#kota_tujuan').prop('disabled', true);
                }else if($('#jenis_pengiriman').val() == 'ojol'){
                    $('#total_ongkir_act').val('').prop('disabled', false);
                    $('#total_ongkir').val('').prop('disabled', true);
                    $('#kota_tujuan').prop('disabled', false);
                }else if($('#jenis_pengiriman').val() == 'tikieco' || $('#jenis_pengiriman').val() == 'tikireg' || $('#jenis_pengiriman').val() == 'tikions'){
                    var tiki = ''
                    if('tikieco' == $('#jenis_pengiriman').val()){
                        tiki = 'ECO'
                    }else if('tikireg' == $('#jenis_pengiriman').val()){
                        tiki = 'REG'
                    }else{
                        tiki = 'ONS'
                    }
                    $('#total_ongkir_act').val('').prop('disabled', true);
                    $('#total_ongkir').val('').prop('disabled', false);
                    $('#kota_tujuan').prop('disabled', false);
                    if($(this).val() != ''){
                        $.ajax({
                            url: "../../../admin/inventori/penjualan-buku/info-ongkir",
                            data: {
                                _token: $('meta[name="_token"]').attr('content'),
                                city_origin: '152',
                                city_destination: $(this).val(),
                                courier: 'tiki',
                                weight: $('#berat_total').val(),
                            },
                            dataType: "JSON",
                            type: "POST",
                            beforeSend: function(){
                                // Show image container
                                $("#loader").show();
                                $("#loader2").show();
                                $('#submit').attr('disabled','disabled');
                            },
                            success: function (response) {
                                $value = 0
                                $est = ''
                                $end = 0
                                response[0].costs.forEach(function(data) {
                                    if(tiki == data.service && $end == 0){
                                        $value = data.cost[0].value
                                        $est = data.cost[0].etd
                                        $end = 1
                                    }
                                });
                                $('#total_ongkir_act').val(formatter.format($value));
                                $('#total_ongkir').val($value);
                                $('#est_sampai').val($est + ' Hari');
                            },
                            complete:function(data){
                                // Hide image container
                                $("#loader").hide();
                                $("#loader2").hide();
                                $('#submit').removeAttr('disabled');
                            }
                        })
                    }else{
                        $('#total_ongkir_act').val(0);
                        $('#total_ongkir').val(0);
                    }
                }else if($('#jenis_pengiriman').val() == 'posex' || $('#jenis_pengiriman').val() == 'posq9' || $('#jenis_pengiriman').val() == 'pospkk'){
                    var pos = ''
                    if('posex' == $('#jenis_pengiriman').val()){
                        pos = 'Express Next Day Barang'
                    }else if('posq9' == $('#jenis_pengiriman').val()){
                        pos = 'Q9 Barang'
                    }else{
                        pos = 'Paket Kilat Khusus'
                    }
                    $('#total_ongkir_act').val('').prop('disabled', true);
                    $('#total_ongkir').val('').prop('disabled', false);
                    $('#kota_tujuan').prop('disabled', false);
                    if($(this).val() != ''){
                        $.ajax({
                            url: "../../../admin/inventori/penjualan-buku/info-ongkir",
                            data: {
                                _token: $('meta[name="_token"]').attr('content'),
                                city_origin: '152',
                                city_destination: $(this).val(),
                                courier: 'pos',
                                weight: $('#berat_total').val(),
                            },
                            dataType: "JSON",
                            type: "POST",
                            beforeSend: function(){
                                // Show image container
                                $("#loader").show();
                                $("#loader2").show();
                                $('#submit').attr('disabled','disabled');
                            },
                            success: function (response) {
                                $value = 0
                                $end = 0
                                $est = ''
                                response[0].costs.forEach(function(data) {
                                    if(pos == data.service && $end == 0){
                                        $value = data.cost[0].value
                                        $est = data.cost[0].etd
                                        $end = 1
                                    }
                                });
                                $('#total_ongkir_act').val(formatter.format($value));
                                $('#total_ongkir').val($value);
                                $('#est_sampai').val($est);
                            },
                            complete:function(data){
                                // Hide image container
                                $("#loader").hide();
                                $("#loader2").hide();
                                $('#submit').removeAttr('disabled');
                            }
                        })
                    }else{
                        $('#total_ongkir_act').val(0);
                        $('#total_ongkir').val(0);
                    }
                }else{
                    var jne = ''
                    if('jneyes' == $('#jenis_pengiriman').val()){
                        jne = 'CTCYES'
                    }else if('jnereg' == $('#jenis_pengiriman').val()){
                        jne = 'CTC'
                    }else if('jneoke' == $('#jenis_pengiriman').val()){
                        jne = 'OKE'
                    }else{
                        jne = 'REG'
                    }
                    $('#total_ongkir_act').val('').prop('disabled', true);
                    $('#total_ongkir').val('').prop('disabled', false);
                    $('#kota_tujuan').prop('disabled', false);
                    if($(this).val() != ''){
                        $.ajax({
                            url: "../../../admin/inventori/penjualan-buku/info-ongkir",
                            data: {
                                _token: $('meta[name="_token"]').attr('content'),
                                city_origin: '152',
                                city_destination: $(this).val(),
                                courier: 'jne',
                                weight: $('#berat_total').val(),
                            },
                            dataType: "JSON",
                            type: "POST",
                            beforeSend: function(){
                                // Show image container
                                $("#loader").show();
                                $("#loader2").show();
                                $('#submit').attr('disabled','disabled');
                            },
                            success: function (response) {
                                $value = 0
                                $end = 0
                                $est = ''
                                response[0].costs.forEach(function(data) {
                                    if(jne == data.service && $end == 0){
                                        $value = data.cost[0].value
                                        $est = data.cost[0].etd
                                        $end = 1
                                    }
                                });
                                $('#total_ongkir_act').val(formatter.format($value));
                                $('#total_ongkir').val($value);
                                $('#est_sampai').val($est + ' Hari');
                            },
                            complete:function(data){
                                // Hide image container
                                $("#loader").hide();
                                $("#loader2").hide();
                                $('#submit').removeAttr('disabled');
                            }
                        })
                    }else{
                        $('#total_ongkir_act').val(0);
                        $('#total_ongkir').val(0);
                    }
                }
            }else{
                $('#total_ongkir_act').val(0);
                $('#total_ongkir').val(0);
            }
        });
    });
    </script>
    <script>
    $(function () {
        $('#jenis_pengiriman').on('change', function () {
            var formatter = new Intl.NumberFormat('id-ID');
            if($(this).val() == 'tanpakirim'){
                $('#total_ongkir_act').val('').prop('disabled', true);
                $('#total_ongkir').val('').prop('disabled', false);
                $('#total_ongkir_act').val(0);
                $('#total_ongkir').val(0);
                $('#kota_tujuan').prop('disabled', true);
            }else if($(this).val() == 'ojol'){
                $('#total_ongkir_act').val('').prop('disabled', false);
                $('#total_ongkir').val('').prop('disabled', true);
                $('#kota_tujuan').prop('disabled', false);
            }else if($(this).val() == 'tikieco' || $(this).val() == 'tikireg' || $(this).val() == 'tikions'){
                var tiki = ''
                if('tikieco' == $(this).val()){
                    tiki = 'ECO'
                }else if('tikireg' == $(this).val()){
                    tiki = 'REG'
                }else{
                    tiki = 'ONS'
                }
                $('#total_ongkir_act').val('').prop('disabled', true);
                $('#total_ongkir').val('').prop('disabled', false);
                $('#kota_tujuan').prop('disabled', false);
                if($('#kota_tujuan').val() != ''){
                    $.ajax({
                        url: "../../../admin/inventori/penjualan-buku/info-ongkir",
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            city_origin: '152',
                            city_destination: $('#kota_tujuan').val(),
                            courier: 'tiki',
                            weight: $('#berat_total').val(),
                        },
                        dataType: "JSON",
                        type: "POST",
                        beforeSend: function(){
                            // Show image container
                            $("#loader").show();
                            $("#loader2").show();
                            $('#submit').attr('disabled','disabled');
                        },
                        success: function (response) {
                            $value = 0
                            $est = ''
                            $end = 0
                            response[0].costs.forEach(function(data) {
                                if(tiki == data.service && $end == 0){
                                    $value = data.cost[0].value
                                    $est = data.cost[0].etd
                                    $end = 1
                                }
                            });
                            $('#total_ongkir_act').val(formatter.format($value));
                            $('#total_ongkir').val($value);
                            $('#est_sampai').val($est + ' Hari');
                        },
                        complete:function(data){
                            // Hide image container
                            $("#loader").hide();
                            $("#loader2").hide();
                            $('#submit').removeAttr('disabled');
                        }
                    })
                }else{
                    $('#total_ongkir_act').val(0);
                    $('#total_ongkir').val(0);
                }
            }else if($(this).val() == 'posex' || $(this).val() == 'posq9' || $(this).val() == 'pospkk'){
                var pos = ''
                if('posex' == $(this).val()){
                    pos = 'Express Next Day Barang'
                }else if('posq9' == $(this).val()){
                    pos = 'Q9 Barang'
                }else{
                    pos = 'Paket Kilat Khusus'
                }
                $('#total_ongkir_act').val('').prop('disabled', true);
                $('#total_ongkir').val('').prop('disabled', false);
                $('#kota_tujuan').prop('disabled', false);
                if($('#kota_tujuan').val() != ''){
                    $.ajax({
                        url: "../../../admin/inventori/penjualan-buku/info-ongkir",
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            city_origin: '152',
                            city_destination: $('#kota_tujuan').val(),
                            courier: 'pos',
                            weight: $('#berat_total').val(),
                        },
                        dataType: "JSON",
                        type: "POST",
                        beforeSend: function(){
                            // Show image container
                            $("#loader").show();
                            $("#loader2").show();
                            $('#submit').attr('disabled','disabled');
                        },
                        success: function (response) {
                            $value = 0
                            $end = 0
                            $est = ''
                            response[0].costs.forEach(function(data) {
                                if(pos == data.service && $end == 0){
                                    $value = data.cost[0].value
                                    $est = data.cost[0].etd
                                    $end = 1
                                }
                            });
                            $('#total_ongkir_act').val(formatter.format($value));
                            $('#total_ongkir').val($value);
                            $('#est_sampai').val($est);
                        },
                        complete:function(data){
                            // Hide image container
                            $("#loader").hide();
                            $("#loader2").hide();
                            $('#submit').removeAttr('disabled');
                        }
                    })
                }else{
                    $('#total_ongkir_act').val(0);
                    $('#total_ongkir').val(0);
                }
            }else{
                var jne = ''
                if('jneyes' == $(this).val()){
                    jne = 'CTCYES'
                }else if('jnereg' == $(this).val()){
                    jne = 'CTC'
                }else if('jneoke' == $(this).val()){
                    jne = 'OKE'
                }else{
                    jne = 'REG'
                }
                $('#total_ongkir_act').val('').prop('disabled', true);
                $('#total_ongkir').val('').prop('disabled', false);
                $('#kota_tujuan').prop('disabled', false);
                if($('#kota_tujuan').val() != ''){
                    $.ajax({
                        url: "../../../admin/inventori/penjualan-buku/info-ongkir",
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            city_origin: '152',
                            city_destination: $('#kota_tujuan').val(),
                            courier: 'jne',
                            weight: $('#berat_total').val(),
                        },
                        dataType: "JSON",
                        type: "POST",
                        beforeSend: function(){
                            // Show image container
                            $("#loader").show();
                            $("#loader2").show();
                            $('#submit').attr('disabled','disabled');
                        },
                        success: function (response) {
                            $value = 0
                            $end = 0
                            $est = ''
                            response[0].costs.forEach(function(data) {
                                if(jne == data.service && $end == 0){
                                    $value = data.cost[0].value
                                    $est = data.cost[0].etd
                                    $end = 1
                                }
                            });
                            $('#total_ongkir_act').val(formatter.format($value));
                            $('#total_ongkir').val($value);
                            $('#est_sampai').val($est + ' Hari');
                        },
                        complete:function(data){
                            // Hide image container
                            $("#loader").hide();
                            $("#loader2").hide();
                            $('#submit').removeAttr('disabled');
                        }
                    })
                }else{
                    $('#total_ongkir_act').val(0);
                    $('#total_ongkir').val(0);
                }
            }
        });
    });
    </script>
@endsection