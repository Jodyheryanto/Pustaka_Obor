@extends('layouts.base_website')

@section('title', 'Edit Data Induk Buku')
@section('indukbuku', true)

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
                            <form class="form-horizontal" action="{{ route('admin.inventori.induk-buku.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="kode_buku" value="{{ $indukbuku->kode_buku }}">
                                <div class="form-group">
                                    <label>Kode Buku</label>
                                    <div class="controls">
                                        <input type="text" class="form-control required" maxlength="20" minlength="1" placeholder="Nomor Kode Buku" value="{{ $indukbuku->kode_buku }}" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <div class="controls">
                                                <input type="number" value="{{ str_replace(' ', '', $indukbuku->isbn) }}" name="isbn" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor ISBN ex: 9786028519939">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lokasi Gudang</label>
                                            <select class="select2 form-control" name="id_lokasi">
                                                @foreach($lokasi as $data)
                                                <option value="{{ $data->id_lokasi }}" @php if($indukbuku->tb_lokasi_id == $data->id_lokasi) echo 'selected' @endphp>{{ $data->nm_lokasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Judul Buku</label>
                                            <div class="controls">
                                                <input type="text" name="judul_buku" class="form-control required" data-validation-required-message="Judul wajib diisi" placeholder="Judul buku" value="{{ $indukbuku->judul_buku }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nama Pengarang</label>
                                            <select class="select2 form-control" name="id_pengarang">
                                                @foreach($pengarang as $data)
                                                <option value="{{ $data->id_pengarang }}" @php if($indukbuku->tb_pengarang_id == $data->id_pengarang) echo 'selected' @endphp>{{ $data->nm_pengarang }}</option>
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
                                                <input type="number" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="5" minlength="1" placeholder="Jumlah kuantitas" value="{{ $stok->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kategori Buku</label>
                                            <select class="select2 form-control" name="id_kategori">
                                                @foreach($kategori as $data)
                                                <option value="{{ $data->id_kategori }}" @php if($indukbuku->tb_kategori_id == $data->id_kategori) echo 'selected' @endphp>{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tahun Terbit</label>
                                            <div class="controls">
                                                <input type="number" name="tahun_terbit" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Tahun terbit harus 4 digit" maxlength="4" minlength="4" placeholder="Tahun terbit buku" value="{{ $indukbuku->tahun_terbit }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Distributor</label>
                                            <select class="select2 form-control" name="id_distributor">
                                                @foreach($distributor as $data)
                                                <option value="{{ $data->id_distributor }}" @php if($indukbuku->tb_distributor_id == $data->id_distributor) echo 'selected' @endphp>{{ $data->nm_distributor }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Penerbit</label>
                                            <select class="select2 form-control" name="id_penerbit">
                                                @foreach($penerbit as $data)
                                                <option value="{{ $data->id_penerbit }}" @php if($indukbuku->tb_penerbit_id == $data->id_penerbit) echo 'selected' @endphp>{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Penerjemah (pilihan)</label>
                                            <select class="select2 form-control" name="id_penerjemah">
                                                <option value="" selected>Tidak ada penerjemah</option>
                                                @foreach($penerjemah as $data)
                                                <option value="{{ $data->id_penerjemah }}" @php if($indukbuku->tb_penerjemah_id == $data->id_penerjemah) echo 'selected' @endphp>{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Buku</label>
                                    <div class="controls">
                                        <textarea name="deskripsi_buku" class="form-control required" data-validation-required-message="Deskripsi wajib diisi" placeholder="Deskripsi buku">{{ $indukbuku->deskripsi_buku }}</textarea>
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
