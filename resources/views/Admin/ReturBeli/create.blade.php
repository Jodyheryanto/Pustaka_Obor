@extends('layouts.base_website')

@section('title', 'Tambah Data Retur Beli')
@section('returbeli', true)

@section('content')
    <!-- Form wizard with step validation section start -->
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Retur Pembelian Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.inventori.retur-pembelian.create') }}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" id="kode_buku_returbeli" name="kode_buku">
                                <input type="hidden" id="id_supplier_returbeli" name="id_supplier">
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-credit-card"></i> Data Pembelian</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Pembelian</label>
                                                <select class="select2 form-control required" name="id_pembelian_buku" id="opt_pembelian">
                                                    <option value="" selected>-- Pilih pembelian --</option>
                                                @foreach($belibuku as $data)
                                                    <option value="{{ $data->id_pembelian_buku }}">{{ $data->id_pembelian_buku }} - {{ $data->indukbuku->judul_buku }} - Rp. {{ number_format($data->total_harga, 0, '', '.') }} - {{ date('d M Y', strtotime($data->updated_at)) }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Buku</label>
                                                <div class="controls">
                                                    <input type="text" id="buku_beli" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_supplier_beli" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_beli" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_beli" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Total</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" id="total_harga_beli" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <div class="controls">
                                            <textarea name="note" id="note_beli" class="form-control" disabled></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 2 -->
                                <h6><i class="step-icon feather icon-x"></i> Data Retur</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_retur" min="1" max="1" name="qty_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="5" minlength="1" placeholder="Jumlah kuantitas">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_retur_satuan" name="harga_retur_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Total</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" id="total_harga_retur" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <div class="controls">
                                            <textarea name="note_retur" class="form-control required" data-validation-required-message="Note wajib diisi" placeholder="Note"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
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
<!-- Untuk retur beli buku -->
    <script>
        $("#opt_pembelian").change(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            $.ajax({
                url: '../../../admin/inventori/pembelian-buku/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#buku_beli').val(data.info.indukbuku.isbn + ' - ' + data.info.indukbuku.judul_buku);
                        $('#nm_supplier_beli').val(data.info.supplier.nm_supplier);
                        $('#qty_beli').val(data.info.qty);
                        var returbeli = 0;
                        if(data.info.returdetail != undefined){
                            if(data.info.returdetail.length > 1){
                                data.info.returdetail.forEach(function(data) {
                                    returbeli += data.qty;
                                });
                            }else if(data.info.returdetail.length == 1){
                                returbeli += data.info.returdetail[0].qty;
                            }
                        }
                        $("#qty_retur").prop('max', data.info.qty - returbeli);
                        $('#harga_satuan_beli').val(formatter.format(data.info.harga_beli_satuan));
                        $('#total_harga_beli').val(formatter.format(data.info.total_harga));
                        $('#note_beli').val(data.info.note);
                    }
                },
                error: function() {
                }
            });
        });
    </script>
    <script>
        $("#opt_pembelian").change(function() {
            $.ajax({
                url: '../../../admin/inventori/pembelian-buku/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#kode_buku_returbeli').val(data.info.indukbuku.kode_buku);
                        $('#id_supplier_returbeli').val(data.info.supplier.id_supplier);
                    }
                },
                error: function() {
                }
            });
        });
    </script>
    <script>
        $('#qty_retur').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var quantity = $(this).val();
            $.ajax({
                url: '../../../admin/inventori/pembelian-buku/info/' + $("#opt_pembelian").val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        var discount = $('#diskon_retur').val();
                        var iPrice = data.info.harga_beli_satuan;
                        $('#harga_retur_satuan').val(formatter.format(data.info.harga_beli_satuan));
                        var total = quantity * iPrice;
                        $("#total_harga_retur").val(formatter.format(total)); // sets the total price input to the quantity * price
                    }
                },
                error: function() {
                }
            });
        });
    </script>
    <script>
        $('#diskon_retur').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var discount = $(this).val();
            $.ajax({
                url: '../../../admin/inventori/pembelian-buku/info/' + $("#opt_pembelian").val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        var quantity = $('#qty_retur').val();
                        var iPrice = data.info.harga_beli_satuan;
                        $('#harga_retur_satuan').val(formatter.format(data.info.harga_beli_satuan));
                        if(discount !== 0){
                            var harga_diskon = (discount * (quantity * iPrice)) / 100;
                            var total = (quantity * iPrice) - harga_diskon;
                        }else{
                            var total = quantity * iPrice;
                        }
                        $("#total_harga_retur").val(formatter.format(total)); // sets the total price input to the quantity * price
                    }
                },
                error: function() {
                }
            });
        });
    </script>
@endsection