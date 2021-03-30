@extends('layouts.base_website')

@section('title', 'Edit Data Kas Lain-lain')
@section('kaslain2', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Kas Lain-lain</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.buku-besar.kas-lain2.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{ $datakas->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ID Account</label>
                                            <select class="select2 form-control" name="id_account">
                                            @foreach($dataaccount as $data)
                                                <option value="{{ $data->id_account }}" @php if($data->id_account == $datakas->tb_data_account_id) echo 'selected' @endphp>{{ $data->id_account }} - {{ $data->nama_account }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tanggal Transaksi</label>
                                            <div class="controls">
                                                <input type="date" name="tgl_transaksi" class="form-control required" data-validation-required-message="Tanggal Transaksi wajib diisi" placeholder="Tanggal Transaksi kas lain-lain" value="{{ $datakas->tgl_transaksi }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Debit Kas</label>
                                            <div class="controls">
                                                <input type="number" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" min="0" name="debit" class="form-control required" placeholder="Debit kas lain-lain" value="{{ $datakas->debit }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Kredit Kas</label>
                                            <div class="controls">
                                                <input type="number" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" min="0" name="kredit" class="form-control required" placeholder="Kredit kas lain-lain" value="{{ $datakas->kredit }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <div class="controls">
                                        <textarea name="note" class="form-control required" data-validation-required-message="Note wajib diisi" maxLength="1000" placeholder="Note kas lain-lain">{{ $datakas->note }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Input Validation end -->
@endsection