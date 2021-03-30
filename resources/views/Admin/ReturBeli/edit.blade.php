@extends('layouts.base_website')

@section('title', 'Edit Data Retur Beli')
@section('returbeli', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Retur Pembelian Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.inventori.retur-pembelian.update') }}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="id_retur_pembelian" value="{{ $returbeli->id_retur_pembelian }}">
                                <input type="hidden" name="kode_buku" id="kode_buku_returbeli" value="{{ $returbeli->belibuku->indukbuku->kode_buku }}">
                                <input type="hidden" name="kode_buku_sblm" value="{{ $returbeli->belibuku->indukbuku->kode_buku }}">
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-credit-card"></i> Data Pembelian</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Pembelian</label>
                                                <select class="select2 form-control required" name="id_pembelian_buku" id="opt_pembelian">
                                                @foreach($belibuku as $data)
                                                    <option value="{{ $data->id_pembelian_buku }}" @php if($returbeli->tb_pembelian_buku_id == $data->id_pembelian_buku) echo 'selected' @endphp>{{ $data->id_pembelian_buku }} - {{ $data->indukbuku->judul_buku }} - Rp. {{ number_format($data->total_harga, 0, '', '.') }} - {{ date('d M Y', strtotime($data->updated_at)) }}</option>
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
                                                    <input type="text" id="buku_beli" class="form-control" value="{{ $returbeli->belibuku->indukbuku->isbn }} - {{ $returbeli->belibuku->indukbuku->judul_buku }} - {{ $returbeli->belibuku->indukbuku->pengarang->nm_pengarang }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_supplier_beli" class="form-control" value="{{ $returbeli->belibuku->supplier->nm_supplier }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_beli" value="{{ $returbeli->belibuku->qty }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_beli" value="{{ $returbeli->belibuku->harga_beli_satuan }}" class="form-control" disabled>
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
                                                    <input type="text" id="total_harga_beli" value="{{ $returbeli->belibuku->total_harga }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <div class="controls">
                                            <textarea name="note" id="note_beli" class="form-control" disabled>{{ $returbeli->belibuku->note }}</textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 2 -->
                                <h6><i class="step-icon feather icon-x"></i> Data Retur</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status Retur</label>
                                                <div class="controls">
                                                    <select class="form-control" name="status_retur_pembelian">
                                                        <option value="0" @php if('0' == $returbeli->status_retur_pembelian) echo 'selected' @endphp>Tunai</option>
                                                        <option value="1" @php if('1' == $returbeli->status_retur_pembelian) echo 'selected' @endphp>Kredit</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_retur" name="qty_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" max="{{ $returbeli->belibuku->qty }}" min="1" placeholder="Jumlah kuantitas" value="{{ $returbeli->qty }}"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_retur_satuan" name="harga_retur_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" value="{{ $returbeli->belibuku->harga_beli_satuan }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon (optional)</label>
                                                <div class="controls">
                                                    <input type="number" id="diskon_retur" name="diskon_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas"  value="{{ $returbeli->discount }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Total</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" id="total_harga_retur" class="form-control"  value="{{ ($returbeli->belibuku->harga_beli_satuan*$returbeli->qty) - ((($returbeli->belibuku->harga_beli_satuan*$returbeli->qty)*$returbeli->discount)/100) }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <div class="controls">
                                            <textarea name="note_retur" class="form-control required" data-validation-required-message="Note wajib diisi" placeholder="Note">{{ $returbeli->note }}</textarea>
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
    <!-- Input Validation end -->
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
                        $("#qty_retur").prop('max', data.info.qty);
                        $("#diskon_retur").val(data.info.discount);
                        $('#harga_retur_satuan').val(formatter.format(data.info.harga_beli_satuan));
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
            var discount = $('#diskon_retur').val();
            var iPrice = $('#harga_retur_satuan').val();
            if(discount !== 0){
                var harga_diskon = (discount * (quantity * iPrice)) / 100;
                var total = (quantity * iPrice) - harga_diskon;
            }else{
                var total = quantity * iPrice;
            }
            $("#total_harga_retur").val(formatter.format(total)); // sets the total price input to the quantity * price
        });
    </script>
    <script>
        $('#diskon_retur').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var discount = $(this).val();
            var quantity = $('#qty_retur').val();
            var iPrice = $('#harga_retur_satuan').val();
            if(discount !== 0){
                var harga_diskon = (discount * (quantity * iPrice)) / 100;
                var total = (quantity * iPrice) - harga_diskon;
            }else{
                var total = quantity * iPrice;
            }
            $("#total_harga_retur").val(formatter.format(total)); // sets the total price input to the quantity * price
        });
    </script>
@endsection