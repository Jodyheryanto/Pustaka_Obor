@extends('layouts.base_website')

@section('title', 'Edit Data Account')
@section('dataaccount', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Account</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.buku-besar.data-account.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id_account" value="{{ $dataaccount->id_account }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ID Account</label>
                                            <div class="controls">
                                                <input type="text" name="id_account" class="form-control required"  maxLength="20" data-validation-required-message="ID Account wajib diisi" placeholder="ID Data Account" value="{{ $dataaccount->id_account }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Account</label>
                                            <div class="controls">
                                                <input type="text" name="nama_account" class="form-control required" maxLength="100" data-validation-required-message="Nama Account wajib diisi" placeholder="Nama Data Account" value="{{ $dataaccount->nama_account }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Aliran Kas</label>
                                            <div class="controls">
                                                <select class="select2 form-control" name="aliran_kas" placeholder="Aliran Kas Data Account">
                                                    <option value="D" @php if('D' == $dataaccount->aliran_kas) echo 'selected' @endphp>Pendapatan Lain-lain</option>
                                                    <option value="K" @php if('K' == $dataaccount->aliran_kas) echo 'selected' @endphp>Beban Lain-lain</option>
                                                </select>
                                            </div>
                                        </div>
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