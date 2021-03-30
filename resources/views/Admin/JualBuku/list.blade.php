@extends('layouts.base_website')

@section('title', 'Data Penjualan Buku')
@section('jualbuku', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Penjualan Buku</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if(Auth::user()->role === 0 || Auth::user()->role === 2)
                            <a href="{{ route('admin.inventori.penjualan-buku.showCreateForm') }}" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Tambah Data</a>
                            <!-- Button trigger modal -->
                            @endif
                            @if(Auth::user()->role === 0 || Auth::user()->role === 2)
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="feather icon-search"></i>&nbsp; Cetak Faktur
                            </button>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter2">
                            <i class="feather icon-search"></i>&nbsp; Analisa Penjualan
                            </button>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-jual text-center">
                                    <thead>
                                        <tr>
                                            <th>Buku</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Qty</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Status Penjualan</th>
                                            <th>Tanggal Penjualan</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 2)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jualbuku as $data)
                                        <tr class="data-row">
                                            <input type="hidden" id="id_penjualan_buku" value="{{ $data->id_penjualan_buku }}">
                                            <th>{{ $data->indukbuku->isbn }} - {{ $data->indukbuku->judul_buku }} @if($data->is_obral ==  1)<p class="badge badge-warning">Obral</p>@endif</th>
                                            <th>{{ $data->pelanggan->nama }}</th>
                                            <th>{{ $data->qty }}</th>
                                            <th>{{ number_format($data->harga_total, 0, '', '.') }}</th>
                                            @if($data->status_penjualan == '0')
                                                <th><p class="badge badge-success">Tunai</p></th>
                                            @else
                                                <th><p class="badge badge-warning">Non Tunai</p></th>
                                            @endif
                                            <th>{{ date('d M Y', strtotime($data->updated_at)) }}</>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 2)
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- <a href="{{ route('admin.inventori.penjualan-buku.showEditForm', $data->id_penjualan_buku) }}" type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a> -->
                                                    <a title="Detail" href="#" onclick="myFunction({{ $data->id_penjualan_buku }})" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id_penjualan_buku }}">
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->id_penjualan_buku }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <li>Histori</li>
                                                            <li>Transaksi Retur Penjualan</li>
                                                        </ul>
                                                        <form method="POST" action="{{ route('admin.inventori.penjualan-buku.delete') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id_penjualan_buku" value="{{ $data->id_penjualan_buku }}" />
                                                            <input type="hidden" name="id_faktur" value="{{ $data->fakturjual->id_faktur_penjualan }}" />
                                                            <input type="hidden" name="kode_buku" value="{{ $data->indukbuku->kode_buku }}" />
                                                            <input type="hidden" name="qty_jual" value="{{ $data->qty }}" />
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
                                            <th>Buku</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Qty</th>
                                            <th>Harga Total (Rp.)</th>
                                            <th>Status Penjualan</th>
                                            <th>Tanggal Penjualan</th>
                                            @if(Auth::user()->role === 0 || Auth::user()->role === 2)
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Cari Faktur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.inventori.penjualan-buku.showOngkirForm') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Cari Faktur Penjualan</label>
                            <select class="select2 form-control required" name="id_faktur">
                            @foreach($faktur as $data)
                                @if($data !== NULL)
                                    <option value="{{ $data['id_faktur'] }}">{{ $data['id_faktur'] }} - {{ $data['nama_pelanggan'] }} - {{ date( 'd M Y', strtotime($data['tgl_faktur'])) }}</option>
                                @endif
                            @endforeach
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Analisa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.inventori.penjualan-buku.filter') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Berdasarkan : </label>
                            <select class="select2 form-control required" name="kode_analisa">
                                <option value="0">Barang Paling Tinggi QTY Jualnya</option>
                                <option value="1">Barang Paling Tinggi Nilai Jualnya</option>
                                <option value="2">Langganan dengan Nilai Jual Tertinggi</option>
                                <option value="3">Salesman dengan Nilai Jual Tertinggi</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Tanggal Awal</label>
                                    <div class="controls">
                                        <input type="date" name="tgl_mulai" class="form-control" placeholder="Tanggal Mulai" required data-validation-required-message="Tanggal wajib diisi" value="{{ date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
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
                    <div class="col-sm-6">
                        <strong id="tgl_jual"></strong> 
                    </div>
                    <div class="col-sm-6 text-right">
                        <span> <strong>Status:</strong> <span id="status">Pending</span></span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <center>
                    <h4><strong><span id="judul_buku"></span></strong></h4>
                    </center>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <p><strong>Kode Buku : </strong><span id="kode_buku"></span></p>
                            <p><strong>ISBN : </strong><span id="isbn"></span></p>
                        </div>

                        <div class="col-sm-6">
                            <p><strong>Pelanggan : </strong><span id="pelanggan"></span></p>
                            <p><strong>Salesman : </strong><span id="salesman"></span></p>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Harga Akhir</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr style="text-align: center;">
                                <td scope="row">1</td>
                                <td id="jumlah"></td>
                                <td id="harga_satuan"></td>
                                <td id="diskon"></td>
                                <td style="text-align: right;" id="harga_total"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        $('.table-jual').DataTable({
            "order": [[ 5, "desc" ]]
        });
    </script>
    <script>
        var id = null;
        function myFunction(id_penjualan) {
            id = id_penjualan
            $(this).addClass('detail-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

            var options = {
            'backdrop': 'static'
            };
            $('#detail-modal').modal(options)
        }
        $(document).ready(function() {

            // on modal show
            $('#detail-modal').on('show.bs.modal', function() {
                var formatter = new Intl.NumberFormat('id-ID');
                
                $.ajax({
                    url: '../../../admin/inventori/penjualan-buku/info/' + id,
                    type: 'get',
                    data: {},
                    success: function(data) {
                        if (data.success == true) {
                            document.getElementById("kode_buku").innerHTML = data.info.indukbuku.kode_buku;
                            if(data.info.status_penjualan == 0){
                                document.getElementById("status").innerHTML = 'Tunai';
                            }else{
                                document.getElementById("status").innerHTML = 'Kredit';
                            }
                            var date = data.info.updated_at;
                            document.getElementById("tgl_jual").innerHTML = date.slice(0, 10);
                            document.getElementById("isbn").innerHTML = data.info.indukbuku.isbn;
                            if(data.info.is_obral == 1){
                                document.getElementById("judul_buku").innerHTML = data.info.indukbuku.judul_buku + ' (Obral)';
                            }else{
                                document.getElementById("judul_buku").innerHTML = data.info.indukbuku.judul_buku;
                            }
                            
                            if(data.info.salesman !== null){
                                document.getElementById("salesman").innerHTML = data.info.salesman.nama;
                            }else{
                                document.getElementById("salesman").innerHTML = '';
                            }
                            document.getElementById("pelanggan").innerHTML = data.info.pelanggan.nama;
                            document.getElementById("jumlah").innerHTML = data.info.qty;
                            document.getElementById("harga_satuan").innerHTML = 'Rp. ' + formatter.format(data.info.harga_jual_satuan);
                            document.getElementById("harga_total").innerHTML = 'Rp. ' + formatter.format(data.info.harga_total);
                            document.getElementById("diskon").innerHTML = data.info.discount + ' %';
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
    <script>
        $(document).on('click', '.lunas', function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Yakin ?',
                text: "Data status penjualan akan berubah menjadi *Tunai/Lunas*",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, saya yakin!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
            }).then(function (result)
            {
                if (result.value)
                {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: "{{ route('admin.inventori.penjualan-buku.ubahstatus') }}",
                        method: "post",
                        data: {id:id, status: 0},
                        success: function (data)
                        {
                            Swal.fire(
                            {
                                type: "success",
                                title: 'Success!',
                                // text: data,
                                showConfirmButton: false,
                            });

                            setTimeout(function (){
                                location.reload();
                            }, 1000);
                        },
                        error: function()
                        {
                            Swal.fire(
                            {
                                type: "error",
                                title: 'Oops, something went wrong!',
                                text: "Report to Developer if error keeps showing up!",
                                confirmButtonClass: 'btn btn-primary',
                            });
                        }
                    })
                }
            })
        });
    </script>
    <script>
        $(document).on('click', '.kredit', function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Yakin ?',
                text: "Data status penjualan akan kembali menjadi *Kredit*",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, saya yakin!',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-primary ml-1',
                buttonsStyling: false,
            }).then(function (result)
            {
                if (result.value)
                {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: "{{ route('admin.inventori.penjualan-buku.ubahstatus') }}",
                        method: "post",
                        data: {id:id, status: 1},
                        success: function (data)
                        {
                            Swal.fire(
                            {
                                type: "success",
                                title: 'Success!',
                                text: data,
                                showConfirmButton: false,
                            });

                            setTimeout(function (){
                                location.reload();
                            }, 1000);
                        },
                        error: function()
                        {
                            Swal.fire(
                            {
                                type: "error",
                                title: 'Oops, something went wrong!',
                                text: "Report to Developer if error keeps showing up!",
                                confirmButtonClass: 'btn btn-primary',
                            });
                        }
                    })
                }
            })
        });
    </script>
@endsection