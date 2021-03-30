@extends('layouts.base_website')

@section('title', 'Tambah Data Supplier')
@section('supplier', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Supplier</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.master.supplier.create') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Perusahaan</label>
                                            <div class="controls">
                                                <input type="text" name="nm_perusahaan" class="form-control" placeholder="Nama Perusahaan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Supplier</label>
                                            <div class="controls">
                                                <input type="text" name="nm_supplier" class="form-control required" data-validation-required-message="Nama Supplier Wajib diisi" placeholder="Nama Supplier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>No. Telepon</label>
                                            <div class="controls">
                                                <input type="number" name="telepon" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor NPWP harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Supplier">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <div class="controls">
                                        <textarea name="alamat" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Supplier"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <div class="controls">
                                                <select class="select2 form-control required" name="kota" id="city" data-validation-required-message="Kota wajib diisi" placeholder="Kota Supplier">
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
                                                <select class="select2 form-control required" id="district" name="kecamatan" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Supplier">
                                                    <option value="">== Pilih Kecamatan ==</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelurahan</label>
                                            <div class="controls">
                                                <select class="select2 form-control required" id="village" name="kelurahan" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Supplier">
                                                    <option value="">== Pilih Kelurahan ==</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <div class="controls">
                                                <input type="number" id="kode_supplier" name="kode_pos" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kode Pos harus diisi antara 5 digit" maxlength="5" minlength="5" placeholder="Kode Pos Supplier">
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