@extends('layouts.base_website')

@section('title', 'Edit Data Penerjemah')
@section('penerjemah', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Tambah Penerjemah</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.master.penerjemah.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id_penerjemah" value="{{ $penerjemah->id_penerjemah }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <div class="controls">
                                                <input type="text" name="nm_penerjemah" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Penerjemah" value="{{ $penerjemah->nm_penerjemah }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="controls">
                                                <input type="email" name="email" class="form-control required" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Penerjemah" value="{{ $penerjemah->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. Telepon</label>
                                            <div class="controls">
                                                <input type="number" name="telepon" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor NPWP harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Penerjemah" value="{{ $penerjemah->telepon }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>NPWP</label>
                                            <div class="controls">
                                                <input type="number" name="NPWP" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NPWP Penerjemah ex: 018550814412000" value="{{ $penerjemah->NPWP }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <div class="controls">
                                        <textarea name="alamat" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Penerjemah">{{ $penerjemah->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <div class="controls">
                                                <select class="select2 form-control required" name="kota" id="city" data-validation-required-message="Kota wajib diisi" placeholder="Kota Penerjemah">
                                                    @foreach ($cities as $id => $name)
                                                        <option value="{{ $id }}" @php if($penerjemah->tb_kota_id == $id) echo 'selected' @endphp>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <div class="controls">
                                                <select class="select2 form-control required" id="district" name="kecamatan" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Penerjemah">
                                                    @foreach ($districts as $id => $name)
                                                        <option value="{{ $id }}" @php if($penerjemah->tb_kecamatan_id == $id) echo 'selected' @endphp>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelurahan</label>
                                            <div class="controls">
                                                <select class="select2 form-control required" id="village" name="kelurahan" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Penerjemah">
                                                    @foreach ($villages as $id => $name)
                                                        <option value="{{ $id }}" @php if($penerjemah->tb_kelurahan_id == $id) echo 'selected' @endphp>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <div class="controls">
                                                <input type="number" id="kode_penerjemah" name="kode_pos" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kode Pos harus diisi antara 5 digit" maxlength="5" minlength="5" placeholder="Kode Pos Penerjemah" value="{{ $penerjemah->kode_pos }}">
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