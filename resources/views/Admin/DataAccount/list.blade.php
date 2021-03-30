@extends('layouts.base_website')

@section('title', 'Data Account')
@section('dataaccount', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Account</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('admin.buku-besar.data-account.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>ID Account</th>
                                            <th>Nama Account</th>
                                            <th>Aliran Kas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataaccount as $data)
                                        @if($data->id_account != 'NB')
                                        <tr>
                                            <th>{{ $data->id_account }}</th>
                                            <th>{{ $data->nama_account }}</th>
                                            @if($data->aliran_kas == 'K')
                                            <th><p class="badge badge-danger">Kredit</p></th>
                                            @else
                                            <th><p class="badge badge-success">Debit</p></th>
                                            @endif
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- <a href="#" title="Terjual" type="button" id="{{ $data->id }}" class="btn btn-success terjual"><i class="fa fa-check"></i></a> -->
                                                    <a title="Edit" href="{{ route('admin.buku-besar.data-account.showEditForm', $data->id_account) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_account }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_account }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <li>Seluruh Laporan Keuangan</li>
                                                            <li>Item Lain-lain</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.buku-besar.data-account.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_account" value="{{ $data->id_account }}" />
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
                                        @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID Account</th>
                                            <th>Nama Account</th>
                                            <th>Aliran Kas</th>
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
@endsection