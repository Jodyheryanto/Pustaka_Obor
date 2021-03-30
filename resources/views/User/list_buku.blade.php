@extends('layouts.base_user')

@section('title', 'List Buku')

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

    <!-- START: List of Books -->
    <div class="bg-light">
        <div class="container">
            <h3 class="m-1">Data Buku dan Royalti</h3>
            <div class="row">
                <div class="col-12">
                    @php
                        $sumharga = 0;
                    @endphp
                    @foreach($pengarang->indukbuku as $data)
                        @if(count($data->jualdetail) > 0)
                        @php
                            $hargatotal = 0;
                            foreach($data->jualdetail as $data3){
                                if($data3->returroyalti != NULL){
                                    $hargatotal += $data3->total_non_diskon -  $data3->returroyalti->total_non_diskon;
                                }else{
                                    $hargatotal += $data3->total_non_diskon;
                                }
                            }
                        @endphp
                        <div class="w-100 box-shadow p-3 bg-white mt-4 d-flex justify-content-start">
                            <div class="w-100">
                                <img src="/laravel/storage/app/public/{{ $data->cover }}" style="height: 100px; width: auto;" class="float-left mr-3 cover img-fluid" alt="Buku Penulis">
                                <p class="ISBN">#{{ $data->isbn }}</p>
                                <h4 class="judul-buku">{{ $data->judul_buku }}</h4>
                                <p class="font-italic penulis">{{ $pengarang->nm_pengarang }}</p>
                            </div>
                            @if($pengarang->NPWP != '')
                            <p class="ISBN" style="margin-left: auto;">Rp. {{ number_format((($hargatotal * $pengarang->persen_royalti) / 100), 0, '', '.') }}</p>
                            @else
                            <p class="ISBN" style="margin-left: auto;">Rp. {{ number_format((($hargatotal * $pengarang->persen_royalti) / 100) - (((($hargatotal * $pengarang->persen_royalti) / 100) * 15) / 100), 0, '', '.') }}</p>
                            @endif
                            <a  style="margin-left: auto;" href="{{ route('user.grafik-royalti', $data->kode_buku) }}"><img src="/user-assets/design/arrow.svg" alt="black arrow"></a>
                        </div>
                    @php 
                        if($pengarang->NPWP != ''){
                            $sumharga += (($hargatotal * $pengarang->persen_royalti) / 100);
                        }else{
                            $sumharga += (($hargatotal * $pengarang->persen_royalti) / 100) - (((($hargatotal * $pengarang->persen_royalti) / 100) * 15) / 100);
                        }
                    @endphp
                    @endif
                    @endforeach
                    <hr>
                    <div class="w-100 box-shadow p-3 bg-white mt-4 d-flex justify-content-start">
                        <div class="w-100">
                            Jumlah Royalti : 
                        </div>
                        <p class="ISBN" style="margin-left: auto;">Rp. {{ number_format($sumharga, 0, '', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: List of Books -->
@endsection