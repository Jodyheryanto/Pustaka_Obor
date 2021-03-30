@extends('layouts.base_website')

@section('title', 'Data Hutang Obor')
@section('debithutang', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Hutang Saat Ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Modal -->
                                <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered mw-100 w-75" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Detail Hutang</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped" id="records_table">
                                                </table>
                                            </div>
                                            <div class="modal-footer" id="footer-btn"></div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table add-rows text-center">
                                    <thead>
                                        <tr>
                                            <th>No Faktur</th>
                                            <th>Supplier</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kredit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                            $jumlah = 0;
                                            $datautang = array();
                                        @endphp
                                        @foreach($jurnalbeli as $data)
                                        @php
                                            if(!isset($jurnalbeli[$i + 1])){
                                                $id_faktur = $jurnalbeli[$i]->fakturbeli->id_faktur_pembelian . '1';
                                            }else{
                                                $id_faktur = $jurnalbeli[$i + 1]->fakturbeli->id_faktur_pembelian;
                                            }
                                        @endphp
                                        @if($data->fakturbeli->id_faktur_pembelian != $id_faktur)
                                        <tr class="data-row">
                                            <th>{{ $data->fakturbeli->id_faktur_pembelian }} <br> <a title="Detail" href="#" onclick="myFunction('{{ $data->fakturbeli->id_faktur_pembelian }}', {{ $i }})">Detail</a></th>
                                            <th>{{ $data->supplier }}</th>
                                            <th>{{ $data->fakturbeli->belibuku->indukbuku->judul_buku }}</th>
                                            <th>{{ date('d M Y', strtotime($data->tgl_transaksi)) }}</th>
                                            @if($jumlah != 0)
                                            <th>{{ number_format($jumlah += $data->kredit_hutang, 0, '', '.') }}</th>
                                            @else
                                            <th>{{ number_format($data->kredit_hutang, 0, '', '.') }}</th>
                                            @endif
                                            <th>
                                            @if($data->fakturbeli->status_bayar == 1)
                                                <a class="badge badge-success text-white">Lunas</a>
                                            @else
                                                <!-- Button trigger modal -->
                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#exampleModal{{ $data->fakturbeli->id_faktur_pembelian }}">
                                                Belum Bayar
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->fakturbeli->id_faktur_pembelian }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apa Anda Yakin Ingin Melakukan Pelunasan Hutang ?<br><br>
                                                        <strong class="text-danger">Peringatan</strong> Data Tidak Akan Dapat Diubah Kedepannya.
                                                        <form method="get" action="{{ route('admin.hutang-piutang.debit-hutang.showBayarForm', $data->fakturbeli->id_faktur_pembelian) }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>
                                            @endif
                                            </th>
                                            @php
                                                $jumlah = 0;
                                            @endphp
                                        </tr>
                                        @else
                                            @php
                                                $jumlah += $data->kredit_hutang;
                                            @endphp
                                        @endif
                                        @php
                                            $i++;
                                            $datautang[] = array('id_faktur' => $data->fakturbeli->id_faktur_pembelian, 'qty' => $data->fakturbeli->belibuku->qty, 'judul_buku' => $data->fakturbeli->belibuku->indukbuku->judul_buku, 'tgl_transaksi' => $data->tgl_transaksi, 'harga_total' => $data->kredit_hutang, 'status' => $data->fakturbeli->status_bayar);
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No Faktur</th>
                                            <th>Supplier</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kredit</th>
                                            <th>Status</th>
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
@section('page-js')
    <script>
        var id = '';
        var index = '';
        function myFunction(id_pembelian, index_data) {
            id = id_pembelian
            index = index_data
            $(this).addClass('detail-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

            var options = {
            'backdrop': 'static'
            };
            $('#detail-modal').modal(options)
        }
        $(document).ready(function() {

            // on modal show
            $('#detail-modal').on('show.bs.modal', function() {
                $('#records_table').empty();
                $('#footer-btn').empty();
                var todayTime = new Date();
                var formatter = new Intl.NumberFormat('id-ID');
                var datautang = @json($datautang);
                var trHTML = '';
                trHTML += '<tr class="text-center"><th>No Faktur</th><th>Qty</th><th>Judul Buku</th><th>Tanggal Transaksi</th><th>Kredit</th></tr>';
                var sumharga = 0;
                var sumqty = 0;
                var denda = 0;
                var status = 0;
                var tgl_transaksi = null;
                var id_faktur = null;
                datautang.forEach(function(data) {
                    if(data['id_faktur'] == id){
                        sumqty += data.qty;
                        sumharga += data.harga_total;
                        tgl_transaksi = data.tgl_transaksi;
                        status = data.status;
                        id_faktur = data.id_faktur;
                        trHTML += '<tr class="text-center"><td>' + data.id_faktur + '</td><td>' + data.qty + '</td><td>' + data.judul_buku + '</td><td>' + Date(data.tgl_transaksi).toString().substring(4,15) + '</td><td>' + formatter.format(data.harga_total) + '</td></tr>';
                    }
                });
                trHTML += '<tr class="text-center"><td>Qty Jual</td><td>' + sumqty + '</td><td></td><td>Jumlah Harga</td><td>' + formatter.format(sumharga) + '</td></tr>';
                $('#records_table').append(trHTML);
                if(status == 0){
                    btnFooter = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal'+ id_faktur +'">Lunasi</a>';
                }else{
                    btnFooter = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><p href="#" class="btn btn-success">Sudah Lunas</p>';
                }
                $('#footer-btn').append(btnFooter);
            })

            // on modal hide
            $('#detail-modal').on('hide.bs.modal', function() {
                $('.detail-item-trigger-clicked').removeClass('detail-item-trigger-clicked')
                $("#detail-form").trigger("reset");
            })
        })
    </script>
@endsection