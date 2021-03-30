@extends('layouts.base_website')

@section('title', 'Table')

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Table Contoh</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('input') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Add new row</a>
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. Telp</th>
                                            <th>Alamat</th>
                                            <th>NPWP</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pengarang as $data)
                                        <tr>
                                            <th>{{ $data->nm_pengarang }}</th>
                                            <th>{{ $data->email }}</th>
                                            <th>{{ $data->telepon }}</th>
                                            <th>{{ $data->alamat }}, Kel.{{ $data->kelurahan }}, Kec. {{ $data->kecamatan }}, {{ $data->kota }} {{ $data->kode_pos }}</th>
                                            @if($data->NPWP != NULL)
                                            <th><a class="badge badge-success" href="#">Memiliki</a></th>
                                            @else
                                            <th><a class="badge badge-danger" href="#">Memiliki</a></th>
                                            @endif
                                            <th>
                                                <div class="col-lg-12 col-md-12 mb-1 w-100">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('input') }}" class="btn btn-primary">Edit</a>
                                                        <button type="button" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Column 1</th>
                                            <th>Column 2</th>
                                            <th>Column 3</th>
                                            <th>Column 4</th>
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