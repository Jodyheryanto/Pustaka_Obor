@extends('layouts.base_website')

@section('title', 'Data Kas '. $dataaccount->nama_account)
@section('laporankeuangan', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data 
                        @if($dataaccount->aliran_kas == 'K')
                        Beban
                        @else
                        Pendapatan
                        @endif
                        {{ $dataaccount->nama_account }} ({{ $dataaccount->id_account }})
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Note</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kaslain as $data)
                                        <tr>
                                            <th>{{ $data->note }}</th>
                                            <th>{{ date('d M Y', strtotime($data->tgl_transaksi)) }}</th>
                                            <th>{{ number_format($data->debit, 0, '', '.') }}</th>
                                            <th>{{ number_format($data->kredit, 0, '', '.') }}</th>
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- <a href="#" title="Terjual" type="button" id="{{ $data->id }}" class="btn btn-success terjual"><i class="fa fa-check"></i></a> -->
                                                    <a title="Edit" href="{{ route('admin.buku-besar.kas-lain2.showEditForm', $data->id) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
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
                                                        Apa Anda Yakin Ingin Menghapus Data ?<br><br>
                                                        <strong class="text-danger">Peringatan</strong> Data yang akan terpengaruh :
                                                        <ul style="width: 50%; margin: auto;">
                                                            <li>Laporan Keuangan</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.buku-besar.kas-lain2.delete') }}">
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
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection