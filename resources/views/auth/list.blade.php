@extends('layouts.base_website')

@section('title', 'Data User')
@section('user', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data User</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('admin.user.showRegisterForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $data)
                                        <tr>
                                            <th>{{ $data->name }}</th>
                                            <th>{{ $data->email }}</th>
                                            @if($data->role === 0)
                                                <th>Super Admin</th>
                                            @elseif($data->role === 1)
                                                <th>Admin</th>
                                            @elseif($data->role === 2)
                                                <th>Marketing</th>
                                            @elseif($data->role === 3)
                                                <th>Staf Gudang</th>
                                            @else
                                                <th>Admin Royalti</th>
                                            @endif
                                            @if($data->role !== 0)
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a title="Edit" href="{{ route('admin.user.showEditForm', $data->id) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apa Anda Yakin Ingin Menghapus Data ?
                                                        <form method="POST" action="{{ route('admin.user.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id" value="{{ $data->id }}" />
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
                                            @else
                                            <th><p class="badge badge-danger">You can't do anything</p></th>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data User Mobile</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No Telp</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usermobiles as $data)
                                        <tr>
                                            <th>{{ $data->name }}</th>
                                            <th>{{ $data->email }}</th>
                                            <th>{{ $data->no_tlp }}</th>
                                            <th>{{ $data->alamat }}</th>
                                            @if($data->is_block == 0)
                                                <th>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" title="Block" class="btn btn-danger" data-toggle="modal" data-target="#statusModal{{ $data->id_user_mobile }}">
                                                        <i class="fa fa-ban"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="statusModal{{ $data->id_user_mobile }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apa Anda Yakin Ingin Block Akun ini ?<br><br>
                                                            Anda tidak akan bisa mengubah keputusan anda di kemudian hari<br>
                                                            Apabila hal itu terjadi pihak yang diblock harus melakukan register akun kembali.
                                                            <form method="POST" action="{{ route('admin.user.ubah-status') }}">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $data->id_user_mobile }}" />
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
                                            @else
                                                <th><p class="badge badge-danger">Blocked</p></th>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No Telp</th>
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