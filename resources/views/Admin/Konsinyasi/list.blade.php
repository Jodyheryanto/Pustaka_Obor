@extends('layouts.base_website')

@section('title', 'Data Faktur Konsinyasi')
@section('konsinyasi', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Faktur Konsinyasi</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="feather icon-plus"></i>&nbsp; Tambah Data
                            </button>
                            @endif
                            <div class="table-responsive">
                                <table id="konsinyasi" class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>No. Faktur</th>
                                            <th>Buku</th>
                                            <th>Harga Satuan (Rp.)</th>
                                            <th>Qty</th>
                                            <th>Diskon</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Tanggal Titip</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $temp = 0
                                        @endphp
                                        @foreach($faktur as $data)
                                        <tr>
                                            @if($temp === 0 || $data->id_faktur_konsinyasi !== $temp)
                                            <th>{{ $data->id_faktur_konsinyasi }} <br> 
                                                @if(Auth::user()->role === 0 || Auth::user()->name === 1)
                                                @if(str_contains($data->id_faktur_konsinyasi, 'FKTKNST'))
                                                    <p class="badge badge-primary">Faktur Penitip</p>
                                                @elseif(str_contains($data->id_faktur_konsinyasi, 'FKTKNSR'))
                                                    <p class="badge badge-primary">Faktur Retur</p>
                                                @elseif(str_contains($data->id_faktur_konsinyasi, 'FKTKNSP'))
                                                    <p class="badge badge-primary">Faktur Penerima</p>
                                                @else
                                                    <p class="badge badge-primary">Faktur Utang</p>
                                                @endif
                                                <a target="_blank" href="{{ route('admin.faktur.konsinyasi.cetak-faktur', $data->id_faktur_konsinyasi) }}">Cetak</a>
                                                @endif
                                            </th>
                                            @else
                                            <th></th>
                                            @endif
                                            <th>{{ $data->indukbuku->isbn }} - {{ $data->indukbuku->judul_buku }} @if($data->is_obral ==  1)<p class="badge badge-warning">Obral</p>@endif</th>
                                            <th>{{ number_format($data->harga_satuan, 0, '', '.') }}</th>
                                            <th>{{ $data->qty }}</th>
                                            <th>{{ $data->discount }}%</th>
                                            <th>{{ number_format($data->harga_total, 0, '', '.') }}</th>
                                            <th>{{ date('d M Y', strtotime($data->tgl_titip)) }}</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    @if(str_contains($data->id_faktur_konsinyasi, 'FKTKNSU') != true && str_contains($data->id_faktur_konsinyasi, 'FKTKNSRT') != true && str_contains($data->id_faktur_konsinyasi, 'FKTKNSRP') != true)
                                                    <a href="#" title="Terjual" type="button" id="{{ $data->id }}" class="btn btn-success terjual"><i class="fa fa-check"></i></a>
                                                    <button type="button" title="Retur All" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal3{{ $data->id }}">
                                                    <i class="fa fa-archive"></i>
                                                    </button>
                                                    @endif
                                                    <!-- <a href="{{ route('admin.faktur.konsinyasi.showEditForm', $data->id) }}" type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a> -->
                                                    <!-- Button trigger modal -->
                                                    @if(str_contains($data->id_faktur_konsinyasi, 'FKTKNSU') != true)
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                    @elseif(str_contains($data->id_faktur_konsinyasi, 'FKTKNSU') != true && $temp === 0 || $data->id_faktur_konsinyasi !== $temp)
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal2{{ $data->id }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                    @endif
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
                                                            <li>Transaksi saat ini</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.faktur.konsinyasi.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id" value="{{ $data->id }}" />
                                                            <input type="hidden" name="kode_buku" value="{{ $data->indukbuku->kode_buku }}" />
                                                            <input type="hidden" name="qty" value="{{ $data->qty }}" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal2{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apa Anda Yakin Utang ke Penitip Ini Sudah Dibayar <br>(Pada Faktur {{ $data->id_faktur_konsinyasi }}) ?<br><br>
                                                        <strong class="text-danger">Peringatan</strong> Data yang sudah dihapus tidak dapat dikembalikan.
                                                        <form method="POST" action="{{ route('admin.faktur.konsinyasi.delete') }}">
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
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal3{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apa Anda Ingin Mengembalikan Semua Buku <br>(Pada Faktur {{ $data->id_faktur_konsinyasi }}) ?<br><br>
                                                        <strong class="text-danger">Peringatan</strong> Data yang sudah dihapus tidak dapat dikembalikan.
                                                        <form method="GET" action="{{ route('admin.faktur.konsinyasi.not-sold', $data->id) }}">
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
                                            @endif
                                        </tr>
                                        @php 
                                            $temp = $data->id_faktur_konsinyasi
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No. Faktur</th>
                                            <th>Buku</th>
                                            <th>Harga Satuan</th>
                                            <th>Qty</th>
                                            <th>Diskon</th>
                                            <th>Harga Total</th>
                                            <th>Tanggal Titip</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>Aksi</th>
                                            @endif
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Masukkan Pilihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.faktur.konsinyasi.showCreateForm') }}" method="GET">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Posisi</label>
                        <select class="select form-control" name="status_titip">
                            <option value="0">Penitip</option>
                            <option value="1">Penerima</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('page-js')
<script>
    $(document).ready(function() {
        $('#konsinyasi').DataTable( {
            "ordering": false
        } );
    } );
    $(document).on('click', '.terjual', function() {
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Apakah buku telah terjual ?',
            text: "Perubahan ini akan mempengaruhi penjualan dan stok buku !",
            type: 'warning',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: 'Ya, terjual!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonText: 'Batal',
            cancelButtonClass: 'btn btn-danger ml-1',
            closeButtonText: 'Close',
            closeButtonClass: 'btn btn-dark ml-1',
            buttonsStyling: false,
        }).then(function (result)
        {
            if(result.value)
            {
                document.location.href="../../../admin/faktur/konsinyasi/sold/" + id;
            }
        })
    });
</script>
@endsection
