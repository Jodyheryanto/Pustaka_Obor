@extends('layouts.base_website')

@section('title', 'Edit Data Retur Jual')
@section('returjual', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Retur Penjualan Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.inventori.retur-penjualan.update') }}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="id_retur_penjualan" value="{{ $returjual->id_retur_penjualan }}">
                                <input type="hidden" id="kode_buku_returjual" name="kode_buku" value="{{ $returjual->jualbuku->indukbuku->kode_buku }}">
                                <input type="hidden" name="kode_buku_sblm" value="{{ $returjual->jualbuku->indukbuku->kode_buku }}">
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-credit-card"></i> Data Penjualan</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Penjualan</label>
                                                <select class="select2 form-control required" name="id_penjualan_buku" id="opt_penjualan">
                                                @foreach($jualbuku as $data)
                                                    <option value="{{ $data->id_penjualan_buku }}" @php if($returjual->tb_penjualan_buku_id == $data->id_pembelian_buku) echo 'selected' @endphp>{{ $data->id_penjualan_buku }} - {{ $data->indukbuku->judul_buku }} - Rp. {{ number_format($data->harga_total, 0, '', '.') }} - {{ date('d M Y', strtotime($data->updated_at)) }}</option>
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
                                                    <input type="text" id="buku_jual" class="form-control" value="{{ $returjual->jualbuku->indukbuku->isbn }} - {{ $returjual->jualbuku->indukbuku->judul_buku }} - {{ $returjual->jualbuku->indukbuku->pengarang->nm_pengarang }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pelanggan</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_pelanggan" class="form-control" value="{{ $returjual->jualbuku->pelanggan->nama }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Salesman</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_salesman" class="form-control" value="{{ $returjual->jualbuku->salesman->nama }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_jual" class="form-control" value="{{ $returjual->jualbuku->qty }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_jual" class="form-control" value="{{ $returjual->jualbuku->harga_jual_satuan }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon</label>
                                                <div class="controls">
                                                    <input type="number" id="diskon_jual" class="form-control" value="{{ $returjual->jualbuku->discount }}" disabled>
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
                                                    <input type="text" id="total_harga_jual" class="form-control" value="{{ $returjual->jualbuku->harga_total }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Penjualan</label>
                                        <div class="controls">
                                            <input type="text" id="status_jual" class="form-control" value="{{ $returjual->jualbuku->status_penjualan }}" disabled>
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
                                                    <input type="number" id="qty_beli" name="qty_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" max="{{ $returjual->jualbuku->qty }}" min="1" placeholder="Jumlah kuantitas" value="{{ $returjual->qty }}"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_beli" name="harga_retur_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" value="{{ $returjual->harga_satuan }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon (optional)</label>
                                                <div class="controls">
                                                    <input type="number" id="diskon" name="diskon_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas"  value="{{ $returjual->discount }}">
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
                                                    <input type="text" id="total_harga_beli" class="form-control"  value="{{ $returjual->total_harga }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <div class="controls">
                                            <textarea name="note_retur" class="form-control required" data-validation-required-message="Note wajib diisi" placeholder="Note">{{ $returjual->note }}</textarea>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Qty</label>
                                            <div class="controls">
                                                <input type="number" name="qty_retur" min="1" max="{{-- $returbeli->belibuku->qty --}}" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" placeholder="Jumlah kuantitas" value="{{ $returjual->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Retur</label>
                                            <div class="controls">
                                                <input type="text" name="status_retur_penjualan" class="form-control required" data-validation-required-message="Status Wajib diisi" placeholder="Status retur" value="{{-- $returbeli->status_retur_penjualan --}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bukti Retur</label>
                                            <div class="controls">
                                                <input type="text" name="bukti_retur_penjualan" class="form-control required" data-validation-required-message="Bukti wajib diisi" placeholder="Bukti retur" value="{{-- $returbeli->bukti_retur_penjualan --}}">
                                            </div>
                                        </div>
                                    </div> -->
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