@extends('layouts.base_website')

@section('title', 'Edit Data Faktur Konsinyasi')
@section('konsinyasi', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Faktur Konsinyasi</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.faktur.konsinyasi.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{ $faktur->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Buku</label>
                                            <select class="select2 form-control" name="kode_buku" id="opt_buku">
                                            @foreach($indukbuku as $data)
                                                @if($faktur->tb_induk_buku_kode_buku == $data->kode_buku)
                                                    <option value="{{ $data->kode_buku }}" @php if($faktur->tb_induk_buku_kode_buku == $data->kode_buku) echo 'selected' @endphp>{{ $data->judul_buku }} - {{ $data->isbn }}</option>
                                                @elseif($data->stock->qty == 0)
                                                    <option value="" disabled>{{ $data->judul_buku }} - {{ $data->isbn }} (Kosong)</option>
                                                @else
                                                    <option value="{{ $data->kode_buku }}">{{ $data->judul_buku }} - {{ $data->isbn }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Penerima Buku</label>
                                            <select class="select2 form-control" name="id_pelanggan">
                                            @foreach($pelanggan as $data)
                                                <option value="{{ $data->id_pelanggan }}" @php if($faktur->tb_pelanggan_id == $data->id_pelanggan) echo 'selected' @endphp>{{ $data->nama }} - {{ $data->email }}</option>
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
                                                <input type="number" id="qty_beli" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" min="1" placeholder="Jumlah kuantitas" value="{{ $faktur->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Harga Satuan</label>
                                            <div class="controls">
                                                <input type="number" id="harga_satuan_beli" name="harga_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" value="{{ $faktur->harga_jual_satuan }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Diskon (optional)</label>
                                            <div class="controls">
                                                <input type="number" id="diskon" name="diskon" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas"  value="{{ $faktur->discount }}">
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