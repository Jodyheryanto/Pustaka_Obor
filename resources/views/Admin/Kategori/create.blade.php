@extends('layouts.base_website')

@section('title', 'Tambah Data Kategori')
@section('kategori', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Kategori</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.master.kategori.create') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>Nama</label>
                                    <div class="controls">
                                        <input type="text" name="nama" class="form-control required" data-validation-required-message="Nama wajib diisi" placeholder="Nama Kategori">
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