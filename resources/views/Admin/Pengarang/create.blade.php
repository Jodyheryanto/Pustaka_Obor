@extends('layouts.base_website')

@section('title', 'Tambah Data Pengarang')
@section('pengarang', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Pengarang</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.master.pengarang.create') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <strong>Data Diri Pengarang</strong>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <div class="controls">
                                                <input type="text" name="nm_pengarang" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Pengarang">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="controls">
                                                <input type="email" name="email" class="form-control required" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Pengarang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. Telepon</label>
                                            <div class="controls">
                                                <input type="number" name="telepon" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor telepon harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Pengarang">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Negara</label>
                                            <div class="controls">
                                                <select class="select2 form-control required" name="negara" id="country" data-validation-required-message="Negara wajib diisi" placeholder="Negara Pengarang">
                                                    @foreach ($countries as $id => $name)
                                                        @if($id == 101)
                                                        <option value="{{ $id }}" selected>{{ $name }}</option>  
                                                        @else  
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NPWP</label>
                                            <div class="controls">
                                                <input type="number" name="NPWP" id="npwp" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NPWP Pengarang ex: 018550814412000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <div class="controls">
                                                <input type="number" name="NIK" id="nik" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NIK Pengarang ex: 4031371809010005">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <div class="controls">
                                        <textarea name="alamat" class="form-control" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Pengarang"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <div class="controls">
                                                <select class="select2 form-control" name="kota" id="city" placeholder="Kota Pengarang">
                                                    <option value="">== Pilih Kota ==</option>
                                                    @foreach ($cities as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <div class="controls">
                                                <select class="select2 form-control" id="district" name="kecamatan" placeholder="Kecamatan Pengarang">
                                                    <option value="">== Pilih Kecamatan ==</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelurahan</label>
                                            <div class="controls">
                                                <select class="select2 form-control" id="village" name="kelurahan" placeholder="Kelurahan Pengarang">
                                                    <option value="">== Pilih Kelurahan ==</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <div class="controls">
                                                <input type="number" id="kode_pengarang" name="kode_pos" class="form-control" maxlength="5" minlength="0" placeholder="Kode Pos Pengarang">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <strong>Royalti & Akun Bank</strong>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Atas Nama</label>
                                            <div class="controls">
                                                <input type="text" name="nama_rek" class="form-control required" placeholder="Atas nama dalam rekening pengarang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Bank</label>
                                            <div class="controls">
                                                <input type="text" name="bank_rek" class="form-control required" placeholder="Nama bank dalam rekening pengarang">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. Rekening</label>
                                            <div class="controls">
                                                <input type="number" name="no_rek" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor rekening pengarang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Persentase Royalti</label>
                                            <div class="input-group">
                                                <input type="number" name="persen_royalti" min="0" max="100" value="10" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Persentase royalti pengarang" data-validation-required-message="Persentase royalti wajib diisi">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
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