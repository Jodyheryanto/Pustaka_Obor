@extends('layouts.base_website')

@section('title', 'Tambah Data Retur Jual')
@section('returjual', true)

@section('content')
    <!-- Form wizard with step validation section start -->
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Retur Penjualan Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.inventori.retur-penjualan.create') }}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" id="kode_buku_returjual" name="kode_buku">
                                <input type="hidden" id="id_pelanggan_returjual" name="id_pelanggan">
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-credit-card"></i> Data Penjualan</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Penjualan</label>
                                                <select class="select2 form-control required" name="id_penjualan_buku" id="opt_penjualan">
                                                    <option value="" selected>-- Pilih penjualan --</option>
                                                @foreach($jualbuku as $data)
                                                    <option value="{{ $data->id_penjualan_buku }}">{{ $data->id_penjualan_buku }} - {{ $data->indukbuku->judul_buku }} - Rp. {{ number_format($data->harga_total, 0, '', '.') }} - {{ date('d M Y', strtotime($data->updated_at)) }} {{ $data->is_obral == 1 ? '(Obral)' : '' }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Buku</label>
                                                <div class="controls">
                                                    <input type="text" id="buku_jual" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pelanggan</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_pelanggan" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Salesman</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_salesman" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_jual" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_jual" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon</label>
                                                <div class="controls">
                                                    <input type="number" id="diskon_jual" class="form-control" disabled>
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
                                                    <input type="text" id="total_harga_jual" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Penjualan</label>
                                        <div class="controls">
                                            <input type="hidden" id="status_jual" class="form-control" disabled>
                                            <input type="text" id="status_jual_act" class="form-control" disabled>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 2 -->
                                <h6><i class="step-icon feather icon-x"></i> Data Retur</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_retur" name="qty_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="5" minlength="1" placeholder="Jumlah kuantitas">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="hidden" id="harga_retur_satuan_act" name="harga_retur_satuan">
                                                    <input type="number" id="harga_retur_satuan" name="harga_retur_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diskon (optional)</label>
                                                <div class="controls">
                                                <input type="hidden" id="diskon_retur_act" name="diskon_retur">
                                                    <input type="number" id="diskon_retur" name="diskon_retur" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Jumlah kuantitas" disabled>
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
                                                    <input type="text" id="total_harga_retur" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <div class="controls">
                                            <textarea name="note_retur" class="form-control required" data-validation-required-message="Note wajib diisi" placeholder="Note"></textarea>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <div class="controls">
                                                    <input type="number" id="qty_retur" min="1" max="1" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="5" minlength="1" placeholder="Jumlah kuantitas">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status Retur</label>
                                                <div class="controls">
                                                    <input type="text" name="status_retur_penjualan" class="form-control required" data-validation-required-message="Status Wajib diisi" placeholder="Status retur">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Bukti Retur</label>
                                                <div class="controls">
                                                    <input type="text" name="bukti_retur_penjualan" class="form-control required" data-validation-required-message="Bukti retur wajib diisi" placeholder="Bukti retur">
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
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