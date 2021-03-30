@extends('layouts.base_website')

@section('title', 'Data Induk Buku')
@section('indukbuku', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Induk Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                            <a href="{{ route('admin.inventori.induk-buku.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            @endif
                            <!-- Button trigger modal -->
                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="feather icon-search"></i>&nbsp; Laporan Data Stok
                            </button>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter2">
                            <i class="feather icon-search"></i>&nbsp; Laporan Persediaan
                            </button>
                            @endif
                            <div class="table-responsive">
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>Kode Buku</th>
                                            <th>ISBN</th>
                                            <th>Judul Buku</th>
                                            <th>Pengarang</th>
                                            <th>Tahun Terbit</th>
                                            <th>Stok</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($indukbuku as $data)
                                        <tr class="data-row">
                                            <th class="kode_buku">{{ $data->kode_buku }}</th>
                                            <th>{{ $data->isbn }}</th>
                                            <th>{{ $data->judul_buku }} @if($data->is_obral == 1) <p class="badge badge-warning">Obral</p> @endif</th>
                                            <th>{{ $data->pengarang->nm_pengarang }}</th>
                                            <th>{{ $data->tahun_terbit }}</th>
                                            <th>{{ $data->stock->qty }}</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a title="Edit" href="{{ route('admin.inventori.induk-buku.showEditForm', $data->kode_buku) }}" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                    <a title="Detail" href="#" id="detail-item" data-toggle="modal" data-target="#detail-buku" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ str_replace(' ', '', $data->kode_buku) }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ str_replace(' ', '', $data->kode_buku) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <li>Keseluruhan Transaksi</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.inventori.induk-buku.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" class="kode_buku" name="kode_buku" value="{{ $data->kode_buku }}" />
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
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Kode Buku</th>
                                            <th>ISBN</th>
                                            <th>Judul Buku</th>
                                            <th>Pengarang</th>
                                            <th>Tahun Terbit</th>
                                            <th>Stok</th>
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
                <h5 class="modal-title" id="exampleModalLongTitle">Masukkan Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.viewkartustock') }}" method="get">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Tanggal Awal</label>
                                <div class="controls">
                                    <input type="date" name="tgl_mulai" class="form-control" placeholder="Tanggal Mulai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Tanggal Akhir</label>
                                <div class="controls">
                                    <input type="date" name="tgl_selesai" class="form-control" placeholder="Tanggal Selesai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
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
<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Masukkan Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.viewpersediaan') }}" method="get">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Tanggal Awal</label>
                                <div class="controls">
                                    <input type="date" name="tgl_mulai" class="form-control" placeholder="Tanggal Mulai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Tanggal Akhir</label>
                                <div class="controls">
                                    <input type="date" name="tgl_selesai" class="form-control" placeholder="Tanggal Selesai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
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
    <!-- Modal -->
    <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                    <h4><strong><span id="judul_buku"></span></strong></h4>
                    <img id="cover" src="" alt="cover" style="width: auto; height: 70px;">
                    </center>
                    <div class="row mt-2">
                        <div class="col-sm-6">
                            <p><strong>Kode Buku : </strong><span id="kode_buku"></span></p>
                            <p><strong>ISBN : </strong><span id="isbn"></span></p>
                            <p><strong>Pengarang : </strong><span id="nm_pengarang"></span></p>
                            <p><strong>Penerbit : </strong><span id="nm_penerbit"></span></p>
                            <p><strong>Qty Saat Ini : </strong><span id="qty"></span></p>
                            <p><strong>Berat : </strong><span id="berat_buku"></span></p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Tahun Terbit : </strong><span id="tahun_terbit"></span></p>
                            <p><strong>Harga Jual : </strong><span id="harga_jual"></span></p>
                            <p><strong>Penerjemah : </strong><span id="nm_penerjemah"></span></p>
                            <p><strong>Distributor : </strong><span id="nm_distributor"></span></p>
                            <p><strong>Kategori : </strong><span id="nm_kategori"></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <strong>Deskripsi Buku : </strong><p id="deskripsi"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        $(document).ready(function() {
            /**
            * for showing detail item popup
            */

            $(document).on('click', "#detail-item", function() {
                $(this).addClass('detail-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

                var options = {
                'backdrop': 'static'
                };
                $('#detail-modal').modal(options)
            })

            // on modal show
            $('#detail-modal').on('show.bs.modal', function() {
                var el = $(".detail-item-trigger-clicked"); // See how its usefull right here? 
                var row = el.closest(".data-row");

                // get the data
                var id = row.children(".kode_buku").text();
                
                $.ajax({
                    url: '../../../admin/inventori/induk-buku/info/' + id,
                    type: 'get',
                    data: {},
                    success: function(data) {
                        if (data.success == true) {
                            if(data.info.is_obral == 1){
                                document.getElementById("judul_buku").innerHTML = data.info.judul_buku + ' (Obral)';
                            }else{
                                document.getElementById("judul_buku").innerHTML = data.info.judul_buku;
                            }
                            document.getElementById("nm_pengarang").innerHTML = data.info.pengarang.nm_pengarang;
                            document.getElementById("nm_penerbit").innerHTML =  data.info.penerbit.nm_penerbit;
                            document.getElementById("tahun_terbit").innerHTML = data.info.tahun_terbit;
                            document.getElementById("kode_buku").innerHTML = data.info.kode_buku;
                            document.getElementById("isbn").innerHTML = data.info.isbn;
                            document.getElementById("qty").innerHTML = data.info.stock.qty;
                            document.getElementById("tahun_terbit").innerHTML = data.info.tahun_terbit;
                            if(data.info.penerjemah !== null){
                                document.getElementById("nm_penerjemah").innerHTML = data.info.penerjemah.nm_penerjemah;
                            }else{
                                document.getElementById("nm_penerjemah").innerHTML = '';
                            }
                            document.getElementById("nm_distributor").innerHTML = data.info.distributor.nm_distributor;
                            document.getElementById("nm_kategori").innerHTML = data.info.kategori.nama;
                            document.getElementById("harga_jual").innerHTML = 'Rp. ' + data.info.harga_jual;
                            document.getElementById("berat_buku").innerHTML = data.info.berat + ' gram';
                            $('#cover').attr('src', '/laravel/storage/app/public/' + data.info.cover);
                            document.getElementById("deskripsi").innerHTML = data.info.deskripsi_buku;
                        }
                    },
                    error: function() {
                    }
                });
            })

            // on modal hide
            $('#detail-modal').on('hide.bs.modal', function() {
                $('.detail-item-trigger-clicked').removeClass('detail-item-trigger-clicked')
                $("#detail-form").trigger("reset");
            })
        })
    </script>
@endsection