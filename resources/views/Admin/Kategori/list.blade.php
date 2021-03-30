@extends('layouts.base_website')

@section('title', 'Data Kategori')
@section('kategori', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Kategori</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="feather icon-plus"></i>&nbsp; Tambah Data
                            </button>
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kategori as $data)
                                        <tr class="data-row">
                                            <th class="nama_kategori">{{ $data->nama }}</th>
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a title="Edit" href="#" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-modal{{ $data->id_kategori }}"><i class="fa fa-edit"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_kategori }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_kategori }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <li>Induk Buku</li>
                                                            <li>Keseluruhan Transaksi</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.master.kategori.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_kategori" value="{{ $data->id_kategori }}" />
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
                                        <!-- Modal -->
                                        <div class="modal fade" id="edit-modal{{ $data->id_kategori }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Kategori</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.master.kategori.update') }}" method="post">
                                                        <div class="modal-body">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="id_kategori" value="{{ $data->id_kategori }}">
                                                            <div class="form-group">
                                                                <label>Nama</label>
                                                                <div class="controls">
                                                                    <input type="text" id="{{ $data->id_kategori }}" name="nama" class="form-control" data-validation-required-message="Nama wajib diisi" placeholder="Nama Kategori" value="{{ $data->nama }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.master.kategori.create') }}" method="post">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Nama</label>
                            <div class="controls">
                                <input type="text" name="nama" class="form-control" data-validation-required-message="Nama wajib diisi" placeholder="Nama Kategori">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
@endsection