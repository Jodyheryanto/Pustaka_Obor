@extends('layouts.base_website')

@section('title', 'Edit Data Pelanggan')
@section('pelanggan', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Tambah Pelanggan</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.master.pelanggan.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id_pelanggan" value="{{ $pelanggan->id_pelanggan }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <div class="controls">
                                                <input type="text" name="nama" class="form-control" data-validation-required-message="Nama wajib diisi" placeholder="Nama Pelanggan" value="{{ $pelanggan->nama }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="controls">
                                                <input type="email" name="email" class="form-control" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Pelanggan" value="{{ $pelanggan->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. Telepon</label>
                                            <div class="controls">
                                                <input type="number" name="telepon" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor NPWP harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Pelanggan" value="{{ $pelanggan->telepon }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <div class="controls">
                                                <input type="date" name="tanggal_lahir" class="form-control required" placeholder="Tanggal Lahir Pelanggan" value="{{ $pelanggan->tanggal_lahir }}" data-validation-required-message="Tanggal Lahir wajib diisi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Diskon (Optional)</label>
                                            <div class="input-group">
                                                <input type="number" name="diskon" class="form-control required" data-validation-required-message="Diskon minimal masukkan 0" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" min="0" max="100" placeholder="Diskon Pelanggan" value="{{ $pelanggan->discount }}">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <div class="controls">
                                        <textarea name="alamat" class="form-control" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Pelanggan">{{ $pelanggan->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <div class="controls">
                                                <select class="select2 form-control" name="kota" id="city" data-validation-required-message="Kota wajib diisi" placeholder="Kota Pelanggan">
                                                    @foreach ($cities as $id => $name)
                                                        <option value="{{ $id }}" @php if($pelanggan->tb_kota_id == $id) echo 'selected' @endphp>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <div class="controls">
                                                <select class="select2 form-control" id="district" name="kecamatan" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Supplier">
                                                    @foreach ($districts as $id => $name)
                                                        <option value="{{ $id }}" @php if($pelanggan->tb_kecamatan_id == $id) echo 'selected' @endphp>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelurahan</label>
                                            <div class="controls">
                                                <select class="select2 form-control" id="village" name="kelurahan" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Pelanggan">
                                                    @foreach ($villages as $id => $name)
                                                        <option value="{{ $id }}" @php if($pelanggan->tb_kelurahan_id == $id) echo 'selected' @endphp>{{ $name }}</option>
                                                    @endforeach
                                                </select>
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