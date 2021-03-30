@extends('layouts.base_website')

@section('title', 'Tambah Data Penjualan Buku')
@section('jualbuku', true)

@section('content')
    <!-- Form wizard with step validation section start -->
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Penjualan Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.inventori.penjualan-buku.create') }}" method="POST">
                                {{csrf_field()}}
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-user"></i> Pelanggan</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Pelanggan</label>
                                                <select class="select2 form-control" name="id_pelanggan" id="opt_pelanggan">
                                                    <option value="" selected>-- Pelanggan belum terdaftar --</option>
                                                @foreach($pelanggan as $data)
                                                    <option value="{{ $data->id_pelanggan }}">{{ $data->nama }} - {{ $data->email }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nm_pelanggan" id="nm_pelanggan" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Pelanggan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="controls">
                                                    <input type="email" name="email_pelanggan" id="email_pelanggan" class="form-control required" data-validation-required-message="Harus email dan wajib diisi" placeholder="Email Pelanggan">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <div class="controls">
                                                    <input type="number" name="telepon_pelanggan" id="telepon_pelanggan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor NPWP harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Pelanggan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <div class="controls">
                                                    <input type="date" id="tanggal_lahir_pelanggan" name="tanggal_lahir_pelanggan" class="form-control required" placeholder="Tanggal Lahir Pelanggan" data-validation-required-message="Tanggal Lahir wajib diisi">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon (Optional)</label>
                                                <div class="input-group">
                                                    <input type="number"id="diskon_pelanggan" name="diskon_pelanggan" class="form-control" max="100" placeholder="Diskon Pelanggan">
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
                                            <textarea name="alamat_pelanggan" id="alamat_pelanggan" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Pelanggan"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" name="kota_pelanggan" id="city" data-validation-required-message="Kota wajib diisi" placeholder="Kota Supplier">
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
                                                    <select class="select2 form-control required" id="district" name="kecamatan_pelanggan" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Supplier">
                                                        <option value="">== Pilih Kecamatan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" id="village" name="kelurahan_pelanggan" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Supplier">
                                                        <option value="">== Pilih Kelurahan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 2 -->
                                <h6><i class="step-icon feather icon-user"></i> Salesman</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Salesman</label>
                                                <select class="select2 form-control" name="id_salesman" id="opt_salesman">
                                                    <option value="" selected>-- Salesman belum terdaftar --</option>
                                                @foreach($salesman as $data)
                                                    <option value="{{ $data->id_salesman }}">{{ $data->nama }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div class="controls">
                                                    <input type="text" name="nm_salesman" id="nm_salesman" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Pelanggan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 3 -->
                                <h6><i class="step-icon feather icon-credit-card"></i> Data Penjualan</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Buku</label>
                                                <select class="select2 form-control required" name="kode_buku" id="opt_buku">
                                                @foreach($indukbuku as $data)
                                                    @if($data->stock->qty != 0)
                                                        @if($data->is_obral == 1)
                                                            <option value="{{ $data->kode_buku }}">{{ $data->judul_buku }} - {{ $data->isbn }} (Obral)</p></option>
                                                        @else
                                                            <option value="{{ $data->kode_buku }}">{{ $data->judul_buku }} - {{ $data->isbn }}</option>
                                                        @endif
                                                    @else
                                                        <option value="" disabled>{{ $data->judul_buku }} - {{ $data->isbn }} (Kosong)</option>
                                                    @endif
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="status_jual" id="status_jual" value="{{ $buku1 != NULL ? $buku1->is_obral : 0 }}">
                                        <div class="col-md-4">
                                            <div class="form-group mt-2">
                                                <a href="{{ route('admin.inventori.induk-buku.showCreateForm') }}" class="form-control btn btn-primary">Buku Belum Terdaftar ?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_beli" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" max="{{ $max_qty }}" min="1" placeholder="Jumlah kuantitas">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_beli" name="harga_jual_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Harga Jual Satuan harus diisi" maxlength="10" minlength="1" placeholder="Harga Satuan Jual" value="{{ $buku1 != NULL ? $buku1->harga_jual : 0 }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon (optional)</label>
                                                <div class="input-group">
                                                    <input type="number" id="diskon" name="diskon" class="form-control required" data-validation-required-message="Diskon minimal masukkan 0" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" min="0" max="100" placeholder="Jumlah diskon pelanggan">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">%</span>
                                                    </div>
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
                                                    <input type="text" id="total_harga_beli" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Penjualan</label>
                                        <div class="controls">
                                            <select class="form-control" name="status_penjualan">
                                                <option value="0">Tunai</option>
                                                <option value="1">Non Tunai</option>
                                            </select>
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