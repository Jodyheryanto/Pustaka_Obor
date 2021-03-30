@extends('layouts.base_website')

@section('title', 'Data Supplier')
@section('supplier', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Supplier</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('admin.master.supplier.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Supplier</th>
                                            <th>No. Telp</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supplier as $data)
                                        <tr>
                                            <th>{{ $data->nm_perusahaan }}</th>
                                            <th>{{ $data->nm_supplier }}</th>
                                            <th>{{ $data->telepon }}</th>
                                            <th>{{ $data->alamat }}, Kel. {{ ucwords(strtolower($data->kelurahan->name)) }}, Kec. {{ ucwords(strtolower($data->kecamatan->name)) }}, {{ ucwords(strtolower($data->kota->name)) }} {{ $data->kode_pos }}</th>
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a title="Edit" href="{{ route('admin.master.supplier.showEditForm', $data->id_supplier) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_supplier }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_supplier }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <form method="POST" action="{{ route('admin.master.supplier.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_supplier" value="{{ $data->id_supplier }}" />
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
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Supplier</th>
                                            <th>No. Telp</th>
                                            <th>Alamat</th>
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
@endsection