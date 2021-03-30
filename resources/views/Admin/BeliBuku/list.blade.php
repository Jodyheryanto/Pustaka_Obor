@extends('layouts.base_website')

@section('title', 'Data Pembelian Buku')
@section('belibuku', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Pembelian Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('admin.inventori.pembelian-buku.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            <!-- Button trigger modal -->
                            @if(Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 2)
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="feather icon-search"></i>&nbsp; Cetak Bukti
                            </button>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter2">
                            <i class="feather icon-search"></i>&nbsp; Analisa Pembelian
                            </button>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-beli text-center">
                                    <thead>
                                        <tr>
                                            <th>Buku</th>
                                            <th>Nama Supplier</th>
                                            <th>Qty</th>
                                            <th>Harga Beli Satuan (Rp.)</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($belibuku as $data)
                                        <tr>
                                            <th>{{ $data->indukbuku->isbn }} - {{ $data->indukbuku->judul_buku }}</th>
                                            <th>{{ $data->supplier->nm_supplier }}</th>
                                            <th>{{ $data->qty }}</th>
                                            <th>{{ number_format($data->harga_beli_satuan, 0, '', '.') }}</th>
                                            <th>{{ number_format($data->total_harga, 0, '', '.') }}</th>
                                            <th>{{ date('d M Y', strtotime($data->updated_at)) }}</th>
                                            <th>{{ $data->note }}</th>
                                            @if($data->status_pembelian == '0')
                                                <th><p class="badge badge-success">Tunai</p></th>
                                            @else
                                                <th><p class="badge badge-warning">Non Tunai</p></th>
                                            @endif
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- <a href="{{ route('admin.inventori.pembelian-buku.showEditForm', $data->id_pembelian_buku) }}" type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a> -->
                                                    <!-- <form method="POST" class="btn btn-danger" action="{{ route('admin.inventori.pembelian-buku.delete') }}">
                                                        
                                                        <input type="hidden" name="id_pembelian_buku" value="{{ $data->id_pembelian_buku }}" />
                                                        <input type="hidden" name="kode_buku" value="{{ $data->indukbuku->kode_buku }}" />
                                                        <input type="hidden" name="qty_beli" value="{{ $data->qty }}" />
                                                        <button type="submit" class="bg-transparent border-0 p-0 text-white"><i class="fa fa-trash"></i> Delete</button>
                                                    </form> -->
                                                    <!-- Button trigger modal -->
                                                    <button title="Delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_pembelian_buku }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_pembelian_buku }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apa Anda Yakin Ingin Menghapus Data ?<br><br>
                                                        <strong class="text-danger">Peringatan</strong> Data yang akan terpengaruh :
                                                        <ul style="width: 50%; margin: auto;">
                                                            <li>Histori</li>
                                                            <li>Transaksi Retur Pembelian</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.inventori.pembelian-buku.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_pembelian_buku" value="{{ $data->id_pembelian_buku }}" />
                                                            <input type="hidden" name="kode_buku" value="{{ $data->indukbuku->kode_buku }}" />
                                                            <input type="hidden" name="qty_beli" value="{{ $data->qty }}" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Buku</th>
                                            <th>Nama Supplier</th>
                                            <th>Qty</th>
                                            <th>Harga Beli Satuan (Rp.)</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Add rows table -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cari Bukti Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.inventori.pembelian-buku.cetak-faktur') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Cari Bukti Pembelian</label>
                            <select class="select2 form-control required" name="id_faktur">
                            @foreach($faktur as $data)
                                @if($data !== NULL)
                                    <option value="{{ $data['id_faktur'] }}">{{ $data['id_faktur'] }} - {{ $data['nama_supplier'] }} - {{ date( 'd M Y', strtotime($data['tgl_faktur'])) }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Analisa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.inventori.pembelian-buku.filter') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Berdasarkan : </label>
                            <select class="select2 form-control required" name="kode_analisa">
                                <option value="0">Barang Paling Tinggi QTY Belinya</option>
                                <option value="1">Barang Paling Tinggi Nilai Belinya</option>
                                <option value="2">Supplier dengan Nilai Beli Tertinggi</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Tanggal Awal</label>
                                    <div class="controls">
                                        <input type="date" name="tgl_mulai" class="form-control" placeholder="Tanggal Mulai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Tanggal Akhir</label>
                                    <div class="controls">
                                        <input type="date" name="tgl_selesai" class="form-control" placeholder="Tanggal Selesai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        $('.table-beli').DataTable({
            "order": [[ 5, "desc" ]]
        });
    </script>
@endsection