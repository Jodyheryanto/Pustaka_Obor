@extends('layouts.base_user')

@section('title', 'Not Found')

@section('content')
    <!-- START: Search Bar -->
    <nav class="navbar navbar-light bg-white justify-content-between">
        <div class="container">
            <div class="d-none d-sm-block">
                <a href="{{ route('user.index') }}" class="navbar-brand">
                    <img src="/user-assets/img/logo.png" alt="Logo PT Pustaka Obor Indonesia"
                        style="height: 80px; width: auto;">
                </a>
            </div>
            <form class="form-inline" action="{{ route('user.list-buku') }}" method="POST">
                {{csrf_field()}}
                <input class="form-control mr-sm-2" type="search" placeholder="Masukkan NIK penulis buku lain" name="nik" aria-label="Search">
                <button class="btn my-2 my-sm-0 btn-search" type="submit">Cari</button>
            </form>
        </div>
    </nav>
    <!-- END: Search Bar -->

    <!-- START: Not Found Content -->
    <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80vh;">
        <img src="/user-assets/design/not_found_book.svg" class="img-fluid" alt="Illustrasi Tidak Ditemukan Buku yang Dicari">
    </div>
    <!-- END: Not Found Content -->
@endsection