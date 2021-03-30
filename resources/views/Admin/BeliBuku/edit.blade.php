@extends('layouts.base_website')

@section('title', 'Edit Data Induk Buku')
@section('belibuku', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Induk Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.inventori.pembelian-buku.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id_pembelian_buku" value="{{ $belibuku->id_pembelian_buku }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Buku</label>
                                            <select class="select2 form-control" name="kode_buku">
                                            @foreach($indukbuku as $data)
                                                <option value="{{ $data->kode_buku }}" @php if($belibuku->tb_induk_buku_kode_buku == $data->kode_buku) echo 'selected' @endphp>{{ $data->judul_buku }} - {{ $data->isbn }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <select class="select2 form-control" name="id_supplier" id="opt_supplier">
                                            @foreach($supplier as $data)
                                                <option value="{{ $data->id_supplier }}" @php if($belibuku->tb_supplier_id == $data->id_supplier) echo 'selected' @endphp>{{ $data->nm_supplier }}</option>
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
                                                <input type="number" id="qty_beli" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="5" minlength="1" placeholder="Jumlah kuantitas" value="{{ $belibuku->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Harga Satuan</label>
                                            <div class="controls">
                                                <input type="number" id="harga_satuan_beli" name="harga_beli_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" value="{{ $belibuku->harga_beli_satuan }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="text" id="total_harga_beli" class="form-control" value="{{ number_format($belibuku->total_harga, 0, '', '.') }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <div class="controls">
                                        <textarea name="note" class="form-control required" data-validation-required-message="Deskripsi wajib diisi" placeholder="Deskripsi buku">{{ $belibuku->note }}</textarea>
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