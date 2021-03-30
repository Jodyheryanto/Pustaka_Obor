@extends('layouts.base_user')

@section('title', 'Laporan Royalti')

@section('content')
    <!-- START: Seach Book -->
  <div class="container">
    <div class="row">

      <div class="col-12 col-md-6">

        <div class="div_logo">
          <img src="/user-assets/img/logo.png" class="logo" alt="Logo PT Pustaka Obor Indonesia">
        </div>
        <h1 class="text-capitalize text-judul mb-4">cek laporan <br> penjualan <br> bukumu disini</h1>
        <form action="{{ route('user.list-buku') }}" method="POST">
          {{csrf_field()}}
          <div class="form-group">
            <input type="text" class="form-control" name="nik" placeholder="Masukan NIK penulis buku">
          </div>
          <button class="btn btn-cari">Cari</button>
        </form>
      </div>

      <div class="col-12 col-md-6 d-flex align-items-center">
        <img src="/user-assets/design/list.svg" class="image-svg d-none d-sm-block" style="width:500px; height: auto;"
          alt="list buku">
      </div>
      <img src="/user-assets/img/meja.png" class="meja" alt="Meja dengan buku, kopi, alat tulis dan pot bunga">

    </div>

  </div>
  <!-- END: Seach Book -->
@endsection