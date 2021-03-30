@extends('layouts.base_website')

@section('title', 'Tambah Data Faktur Konsinyasi')
@section('konsinyasi', true)

@section('content')
    <!-- Form wizard with step validation section start -->
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Faktur Konsinyasi (Terima)</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="steps-validation wizard-circle" action="{{ route('admin.faktur.konsinyasi.create') }}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="status_titip" value="1">
                                <!-- Step 1 -->
                                <h6><i class="step-icon feather icon-user"></i> Penerima Barang Titip</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cari Data Penitip</label>
                                                <select class="select2 form-control" name="id_supplier" id="opt_supplier">
                                                    <option value="" selected>-- Penitip belum terdaftar --</option>
                                                @foreach($supplier as $data)
                                                    <option value="{{ $data->id_supplier }}">{{ $data->nm_supplier }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_perusahaan" name="nm_perusahaan" class="form-control" placeholder="Nama Perusahaan">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Penitip</label>
                                                <div class="controls">
                                                    <input type="text" id="nm_supplier" name="nm_supplier" class="form-control required" data-validation-required-message="Nama Penitip Wajib diisi" placeholder="Nama Penitip">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <div class="controls">
                                                    <input type="number" id="telepon_supplier" name="telepon" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Nomor Telepon harus diisi antara 8 - 15 digit" maxlength="15" minlength="8" placeholder="Nomor telepon Penitip">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <div class="controls">
                                            <textarea name="alamat" id="alamat_supplier" class="form-control required" data-validation-required-message="Alamat wajib diisi" placeholder="Alamat Penitip"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" name="kota" id="city" data-validation-required-message="Kota wajib diisi" placeholder="Kota Penitip">
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
                                                    <select class="select2 form-control required" id="district" name="kecamatan" data-validation-required-message="Kecamatan wajib diisi" placeholder="Kecamatan Penitip">
                                                        <option value="">== Pilih Kecamatan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <div class="controls">
                                                    <select class="select2 form-control required" id="village" name="kelurahan" data-validation-required-message="Kelurahan wajib diisi" placeholder="Kelurahan Penitip">
                                                        <option value="">== Pilih Kelurahan ==</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Pos</label>
                                                <div class="controls">
                                                    <input type="number" id="kode_supplier" name="kode_pos" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kode Pos harus diisi antara 5 digit" maxlength="5" minlength="5" placeholder="Kode Pos Penitip">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Step 2 -->
                                <h6><i class="step-icon feather icon-credit-card"></i> Data Faktur Konsinyasi</h6>
                                <fieldset>
                                    <div class="form-group">
                                        <label>ID Faktur</label>
                                        <select class="select2 form-control" name="id_faktur_konsinyasi">
                                                <option value="">-- Faktur Baru --</option>
                                        @foreach($faktur as $data)
                                                @if($data !== NULL)
                                                    @php 
                                                        $faktur = preg_split('#(?<=[a-z])(?=\d)#i', $data['id_faktur'])
                                                    @endphp
                                                    @if($faktur[0] == 'FKTKNSP')
                                                        <option value="{{ $data['id_faktur'] }}">{{ $data['id_faktur'] }} - {{ date('d M Y', strtotime($data['tgl_faktur'])) }} - {{ $data['nm_distributor'] }}</option>
                                                    @endif
                                                @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Buku</label>
                                                <select class="select2 form-control required" name="kode_buku" id="opt_buku">
                                                @foreach($indukbuku as $data)
                                                    @if($data->stock->qty != 0)
                                                        @if($data->is_obral == 1)
                                                        <option value="" disabled>{{ $data->judul_buku }} - {{ $data->isbn }} (Obral)</option>
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
                                                    <input type="number" id="qty_beli" name="qty" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" min="1" placeholder="Jumlah kuantitas">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <div class="controls">
                                                    <input type="number" id="harga_satuan_beli" name="harga_satuan" class="form-control required" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" data-validation-required-message="Kuantitas harus diisi" maxlength="10" minlength="1" placeholder="Harga Satuan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                    <!-- <div class="form-group">
                                        <label>Status Penitipan</label>
                                        <div class="controls">
                                            <select class="form-control" name="status">
                                                <option value="0">Penerima</option>
                                                <option value="1">Penitip</option>
                                            </select>
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
@section('page-js')
<script>
    $("#opt_buku").change(function() {
        $.ajax({
            url: '../../../admin/inventori/induk-buku/info/' + $(this).val(),
            type: 'get',
            data: {},
            success: function(data) {
                if (data.success == true) {
                    $("#qty_beli").prop('max', data.info.stock.qty);
                }
            },
            error: function() {
            }
        });
    });
</script>
@endsection