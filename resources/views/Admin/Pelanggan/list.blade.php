@extends('layouts.base_website')

@section('title', 'Data Pelanggan')
@section('pelanggan', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Pelanggan</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                            <a href="{{ route('admin.master.pelanggan.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            @endif
                            @if(Auth::user()->role === 0 || Auth::user()->role === 2)
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="feather icon-search"></i>&nbsp; Analisa Pelanggan
                            </button>
                            @endif
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. Telp</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Lahir</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pelanggan as $data)
                                        <tr>
                                            <th>{{ $data->nama }}</th>
                                            <th>{{ $data->email }}</th>
                                            <th>{{ $data->telepon }}</th>
                                            <th>{{ $data->alamat }}, Kel. {{ ucwords(strtolower($data->kelurahan->name)) }}, Kec. {{ ucwords(strtolower($data->kecamatan->name)) }}, {{ ucwords(strtolower($data->kota->name)) }} {{ $data->kode_pos }}</th>
                                            <th>{{ date('d M Y', strtotime($data->tanggal_lahir)) }}</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a title="Edit" href="{{ route('admin.master.pelanggan.showEditForm', $data->id_pelanggan) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_pelanggan }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_pelanggan }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <li>Transaksi Penjualan</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.master.pelanggan.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_pelanggan" value="{{ $data->id_pelanggan }}" />
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
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. Telp</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Lahir</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>Aksi</th>
                                            @endif
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
                <h5 class="modal-title" id="exampleModalLongTitle">Masukkan Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.viewpelanggan') }}" method="get">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Tanggal Awal</label>
                                <div class="controls">
                                    <input type="date" name="tgl_mulai" class="form-control" placeholder="Tanggal Mulai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
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