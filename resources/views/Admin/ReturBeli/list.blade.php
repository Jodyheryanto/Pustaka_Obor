@extends('layouts.base_website')

@section('title', 'Data Retur Pembelian')
@section('returbeli', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Retur Pembelian Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('admin.inventori.retur-pembelian.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="feather icon-search"></i>&nbsp; Cetak Faktur
                            </button>
                            <div class="table-responsive">
                                <table class="table table-retur text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pembelian</th>
                                            <th>Qty</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Note</th>
                                            <th>Tanggal Retur</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($returbeli as $data)
                                        <tr>
                                            <th>{{ $data->id_retur_pembelian }}</th>
                                            <th>{{ $data->belibuku->id_pembelian_buku }} - {{ $data->belibuku->indukbuku->judul_buku }} - Rp. {{ number_format($data->belibuku->total_harga, 0, '', '.') }}</th>
                                            <th>{{ $data->qty }}</th>
                                            <th>{{ number_format($data->belibuku->harga_beli_satuan * $data->qty, 0, '', '.') }}</th>
                                            <th>{{ $data->note }}</th>
                                            <th>{{ date('d M Y', strtotime($data->updated_at)) }}</th>
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- <a href="{{ route('admin.inventori.retur-pembelian.showEditForm', $data->id_retur_pembelian) }}" type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a> -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_retur_pembelian }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_retur_pembelian }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <li>Jurnal Umum</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.inventori.retur-pembelian.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_retur_pembelian" value="{{ $data->id_retur_pembelian }}" />
                                                            <input type="hidden" name="kode_buku" value="{{ $data->belibuku->indukbuku->kode_buku }}" />
                                                            <input type="hidden" name="qty_retur" value="{{ $data->qty }}" />
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
                                            <th>ID</th>
                                            <th>Pembelian</th>
                                            <th>Qty</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Note</th>
                                            <th>Tanggal Retur</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Cari Faktur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.inventori.retur-pembelian.cetak-faktur') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Cari Faktur Retur Pembelian</label>
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
@endsection
@section('page-js')
    <script>
        $('.table-retur').DataTable({
            "order": [[ 5, "desc" ]]
        });
    </script>
@endsection