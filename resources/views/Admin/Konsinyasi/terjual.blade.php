@extends('layouts.base_website')

@section('title', 'Penjualan buku pada konsinyasi')
@section('konsinyasi', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Penjualan buku pada konsinyasi</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.faktur.konsinyasi.sold') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{ $faktur->id }}">
                                <input type="hidden" name="status_titip" value="{{ $faktur->status_titip }}">
                                @if($faktur->status_titip == 0)
                                    <input type="hidden" name="id_pelanggan" value="{{ $faktur->tb_pelanggan_id }}">
                                @else
                                    <input type="hidden" name="id_supplier" value="{{ $faktur->tb_supplier_id }}">
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Buku</label>
                                            <input type="hidden" name="kode_buku" value="{{ $faktur->tb_induk_buku_kode_buku }}">
                                            <select class="select2 form-control" id="opt_buku" disabled>
                                            @foreach($indukbuku as $data)
                                                @if($faktur->tb_induk_buku_kode_buku == $data->kode_buku)
                                                    <option value="{{ $data->kode_buku }}" @php if($faktur->tb_induk_buku_kode_buku == $data->kode_buku) echo 'selected' @endphp>{{ $data->judul_buku }} - {{ $data->isbn }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Qty</label>
                                            <div class="controls">
                                                <input type="number" id="qty_beli" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus min 1 dan max {{ $faktur->qty }}" max="{{ $faktur->qty }}" min="1" placeholder="Jumlah kuantitas" value="{{ $faktur->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Harga Satuan</label>
                                            <input type="hidden" name="harga_satuan" value="{{ $faktur->harga_satuan }}">
                                            <div class="controls">
                                                <input type="number" id="harga_satuan_beli" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" value="{{ $faktur->harga_satuan }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Diskon (optional)</label>
                                            <input type="hidden" name="diskon" value="{{ $faktur->discount }}" @if($faktur->status_titip) @php echo 'disabled' @endphp @endif>
                                            <div class="controls">
                                                <input type="number" id="diskon" name="diskon" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Diskon penjualan"  value="{{ $faktur->discount }}" disabled>
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
                                                <input type="text" id="total_harga_beli" class="form-control" value="{{ $faktur->harga_total }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Penerima</label>
                                            <input type="hidden" name="id_pelanggan" value="{{ $faktur->tb_pelanggan_id }}">
                                            <select class="select2 form-control" disabled>
                                            @foreach($pelanggan as $data)
                                                <option value="{{ $data->id_pelanggan }}" @php if($faktur->tb_pelanggan_id == $data->id_pelanggan) echo 'selected' @endphp>{{ $data->nama }} - {{ $data->email }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Input Validation end -->
@endsection