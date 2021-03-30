@extends('layouts.base_website')

@section('title', 'Tambah Data Induk Buku')
@section('indukbuku', true)

@section('content')
    <!-- Form wizard with step validation section start -->
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Induk Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.inventori.induk-buku.create') }}" method="POST">
                                {{csrf_field()}}
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-book"></i> Data Buku</h6>
                                <fieldset>
                                    <div class="form-group">
                                        <label>Kode Buku</label>
                                        <div class="controls">
                                            <input type="text" name="kode_buku" class="form-control required" maxlength="20" minlength="1" data-validation-required-message="Kode Buku harus 1 - 20 digit" placeholder="Nomor Kode Buku">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ISBN</label>
                                                <div class="controls">
                                                    <input type="number" name="isbn" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor ISBN ex: 9786028519939">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Lokasi Gudang</label>
                                                <select class="select2 form-control" name="id_lokasi">
                                                    @foreach($lokasi as $data)
                                                    <option value="{{ $data->id_lokasi }}">{{ $data->nm_lokasi }}</option>
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
                                                    <input type="text" name="judul_buku" class="form-control required" data-validation-required-message="Judul wajib diisi" placeholder="Judul buku">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="5" minlength="1" placeholder="Jumlah kuantitas">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kategori Buku</label>
                                                <select class="select2 form-control" name="id_kategori">
                                                    @foreach($kategori as $data)
                                                    <option value="{{ $data->id_kategori }}">{{ $data->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tahun Terbit</label>
                                                <div class="controls">
                                                    <input type="number" name="tahun_terbit" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Tahun terbit harus 4 digit" maxlength="4" minlength="4" placeholder="Tahun terbit buku">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Buku</label>
                                        <div class="controls">
                                            <textarea name="deskripsi_buku" class="form-control required" data-validation-required-message="Deskripsi wajib diisi" placeholder="Deskripsi buku"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Buku</label>
                                        <div class="controls">
                                            <select name="status" id="" class="form-control">
                                                <option value="0">Gudang / Pembelian</option>
                                                <option value="1">Barang Titip</option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 2 -->
                                <h6><i class="step-icon feather icon-user"></i> Pengarang</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Pengarang</label>
                                                <select class="select2 form-control" name="id_pengarang" id="opt_pengarang">
                                                    <option value="" selected>-- Pengarang Belum Terdaftar --</option>
                                                    @foreach($pengarang as $data)
                                                    <option value="{{ $data->id_pengarang }}">{{ $data->nm_pengarang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nm_pengarang" id="nm_pengarang" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Pengarang" value=''>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="controls">
                                                    <input type="email" name="email_pengarang" id="email_pengarang" class="form-control required" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Pengarang" value=''>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <div class="controls">
                                                    <input type="number" name="telepon_pengarang" id="telepon_pengarang" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor Telepon harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Pengarang" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Negara</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" name="negara_pengarang" id="country_pengarang" data-validation-required-message="Negara wajib diisi" placeholder="Negara Pengarang">
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
                                                    <input type="number" name="NPWP_pengarang" id="npwp_pengarang" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NPWP Pengarang ex: 018550814412000" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <div class="controls">
                                                    <input type="number" name="NIK_pengarang" id="nik_pengarang" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NPWP Pengarang ex: " value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <div class="controls">
                                            <textarea name="alamat_pengarang" id="alamat_pengarang" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Pengarang"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" name="kota_pengarang" id="kota_pengarang" data-validation-required-message="Kota wajib diisi" placeholder="Kota Pengarang">
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
                                                    <select class="select2 form-control" id="kecamatan_pengarang" name="kecamatan_pengarang" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Pengarang">
                                                        <option value="">== Pilih Kecamatan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <div class="controls">
                                                    <select class="select2 form-control" id="kelurahan_pengarang" name="kelurahan_pengarang" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Pengarang">
                                                        <option value="">== Pilih Kelurahan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Pos</label>
                                                <div class="controls">
                                                    <input type="number" id="kode_pengarang" name="kode_pos_pengarang" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kode Pos harus diisi antara 5 digit" maxlength="5" minlength="5" placeholder="Kode Pos Pengarang">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Atas Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nama_rek_pengarang" id="nama_rek_pengarang" class="form-control required" placeholder="Atas nama dalam rekening pengarang">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Bank</label>
                                                <div class="controls">
                                                    <input type="text" name="bank_rek_pengarang" id="bank_rek_pengarang" class="form-control required" placeholder="Nama bank dalam rekening pengarang">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Rekening</label>
                                                <div class="controls">
                                                    <input type="number" name="no_rek_pengarang" id="no_rek_pengarang" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor rekening pengarang">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 3 -->
                                <h6><i class="step-icon feather icon-truck"></i> Distributor</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Distributor</label>
                                                <select class="select2 form-control" name="id_distributor" id="opt_distributor">
                                                    <option value="" selected>-- Distributor Belum Terdaftar --</option>
                                                    @foreach($distributor as $data)
                                                    <option value="{{ $data->id_distributor }}">{{ $data->nm_distributor }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nm_distributor" id="nm_distributor" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Distributor">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="controls">
                                                    <input type="email" name="email_distributor" id="email_distributor" class="form-control required" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Distributor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <div class="controls">
                                                    <input type="number" name="telepon_distributor" id="telepon_distributor" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor NPWP harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Distributor">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>NPWP</label>
                                                <div class="controls">
                                                    <input type="number" name="NPWP_distributor" id="npwp_distributor" class="form-control" placeholder="Nomor NPWP Distributor ex: 018550814412000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <div class="controls">
                                            <textarea name="alamat_distributor" id="alamat_distributor" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Distributor"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota</label>
                                                <div class="controls">
                                                    <select class="select2 form-control" name="kota_distributor" id="kota_distributor" data-validation-required-message="Kota wajib diisi" placeholder="Kota Distributor">
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
                                                    <select class="select2 form-control" id="kecamatan_distributor" name="kecamatan_distributor" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Distributor">
                                                        <option value="">== Pilih Kecamatan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <div class="controls">
                                                    <select class="select2 form-control" id="kelurahan_distributor" name="kelurahan_distributor" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Distributor">
                                                        <option value="">== Pilih Kelurahan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Pos</label>
                                                <div class="controls">
                                                    <input type="number" id="kode_distributor" name="kode_pos_distributor" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kode Pos harus diisi antara 5 digit" maxlength="5" minlength="5" placeholder="Kode Pos Distributor">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 4 -->
                                <h6><i class="step-icon feather icon-user"></i> Penerbit</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Penerbit</label>
                                                <select class="select2 form-control" name="id_penerbit" id="opt_penerbit">
                                                    <option value="" selected>-- Penerbit Belum Terdaftar --</option>
                                                    @foreach($penerbit as $data)
                                                    <option value="{{ $data->id_penerbit }}">{{ $data->nm_penerbit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nm_penerbit" id="nm_penerbit" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Penerbit" value=''>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="controls">
                                                    <input type="email" name="email_penerbit" id="email_penerbit" class="form-control required" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Penerbit" value=''>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <div class="controls">
                                                    <input type="number" name="telepon_penerbit" id="telepon_penerbit" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor Telepon harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Penerbit" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>NPWP</label>
                                                <div class="controls">
                                                    <input type="number" name="NPWP_penerbit" id="npwp_penerbit" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NPWP Penerbit ex: 018550814412000" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <div class="controls">
                                            <textarea name="alamat_penerbit" id="alamat_penerbit" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Penerbit"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" name="kota_penerbit" id="kota_penerbit" data-validation-required-message="Kota wajib diisi" placeholder="Kota Penerbit">
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
                                                    <select class="select2 form-control" id="kecamatan_penerbit" name="kecamatan_penerbit" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Penerbit">
                                                        <option value="">== Pilih Kecamatan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <div class="controls">
                                                    <select class="select2 form-control" id="kelurahan_penerbit" name="kelurahan_penerbit" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Penerbit">
                                                        <option value="">== Pilih Kelurahan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Pos</label>
                                                <div class="controls">
                                                    <input type="number" id="kode_penerbit" name="kode_pos_penerbit" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kode Pos harus diisi antara 5 digit" maxlength="5" minlength="5" placeholder="Kode Pos Penerbit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 5 -->
                                <h6><i class="step-icon feather icon-user"></i> Penerjemah</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Penerjemah</label>
                                                <select class="select2 form-control" name="id_penerjemah" id="opt_penerjemah">
                                                    <option value="" selected>-- Penerjemah Belum Terdaftar --</option>
                                                    @foreach($penerjemah as $data)
                                                    <option value="{{ $data->id_penerjemah }}">{{ $data->nm_penerjemah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nm_penerjemah" id="nm_penerjemah" class="form-control" placeholder="Nama Penerjemah" value=''>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="controls">
                                                    <input type="email" name="email_penerjemah" id="email_penerjemah" class="form-control" placeholder="Email Penerjemah" value=''>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <div class="controls">
                                                    <input type="number" name="telepon_penerjemah" id="telepon_penerjemah" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" maxlength="15" minlength="8" placeholder="Nomor telepon Penerjemah" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>NPWP</label>
                                                <div class="controls">
                                                    <input type="number" name="NPWP_penerjemah" id="npwp_penerjemah" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" placeholder="Nomor NPWP Penerjemah ex: 018550814412000" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <div class="controls">
                                            <textarea name="alamat_penerjemah" id="alamat_penerjemah" class="form-control" placeholder="Alamat Penerjemah"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota</label>
                                                <div class="controls">
                                                    <select class="select2 form-control" name="kota_penerjemah" id="kota_penerjemah" placeholder="Kota Penerjemah">
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
                                                    <select class="select2 form-control" id="kecamatan_penerjemah" name="kecamatan_penerjemah" placeholder="Kecamatan Penerjemah">
                                                        <option value="">== Pilih Kecamatan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <div class="controls">
                                                    <select class="select2 form-control" id="kelurahan_penerjemah" name="kelurahan_penerjemah" placeholder="Kelurahan Penerjemah">
                                                        <option value="">== Pilih Kelurahan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Pos</label>
                                                <div class="controls">
                                                    <input type="number" id="kode_penerjemah" name="kode_pos_penerjemah" class="form-control" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" maxlength="5" minlength="5" placeholder="Kode Pos Penerjemah">
                                                </div>
                                            </div>
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