@extends('layouts.base_website')

@section('title', 'Edit Data Salesman')
@section('salesman', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Tambah Salesman</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.master.salesman.update') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="id_salesman" value="{{ $salesman->id_salesman }}">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <div class="controls">
                                        <input type="text" name="nama" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Salesman" value="{{ $salesman->nm_salesman }}">
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