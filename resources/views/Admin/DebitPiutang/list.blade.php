@extends('layouts.base_website')

@section('title', 'Data Piutang Obor')
@section('debitpiutang', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Piutang Saat Ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Modal -->
                                <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered mw-100 w-75" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Detail Piutang</h4>
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
                                            <th>Pelanggan</th>
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
                                            $denda = [];
                                        @endphp
                                        @foreach($jurnaljual as $data)
                                        @php
                                            if(!isset($jurnaljual[$i + 1])){
                                                $id_faktur = $jurnaljual[$i]->fakturjual->id_faktur_penjualan . '1';
                                            }else{
                                                $id_faktur = $jurnaljual[$i + 1]->fakturjual->id_faktur_penjualan;
                                            }
                                        @endphp
                                        @if($data->fakturjual->id_faktur_penjualan != $id_faktur)
                                        <tr class="data-row">
                                            <th>{{ $data->fakturjual->id_faktur_penjualan }} <br> <a title="Detail" href="#" onclick="myFunction('{{ $data->fakturjual->id_faktur_penjualan }}', {{ $i }})">Detail</a></th>
                                            <th>{{ $data->pelanggan }}</th>
                                            <th>{{ $data->fakturjual->jualbuku->indukbuku->judul_buku }} @if($data->fakturjual->jualbuku->is_obral == 1) <p class="badge badge-warning">Obral</p> @endif</th>
                                            <th>{{ date('d M Y', strtotime($data->tgl_transaksi)) }}</th>
                                            @if($jumlah != 0)
                                            <th>{{ number_format($jumlah += $data->kredit_penjualan, 0, '', '.') }}</th>
                                            @else
                                            <th>{{ number_format($data->kredit_penjualan, 0, '', '.') }}</th>
                                            @endif
                                            <th>
                                            @if($data->fakturjual->status_bayar == 1)
                                                {{-- @if($data->kasmasuk->kredit_piutang - $data->kasmasuk->debit_kas_masuk == 0) --}}
                                                <p class="badge badge-success text-white">Lunas</p>
                                                {{-- @else --}}
                                                <!-- <a class="badge badge-warning text-white">Dibayar/Belum Lunas</a> -->
                                                {{-- @endif --}}
                                            @else
                                                <!-- Button trigger modal -->
                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#exampleModal{{ $data->fakturjual->id_faktur_penjualan }}">
                                                Belum Bayar
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $data->fakturjual->id_faktur_penjualan }}" tabindex="-999" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apa Anda Yakin Ingin Melakukan Pelunasan Piutang ?<br><br>
                                                        <strong class="text-danger">Peringatan</strong> Data Tidak Akan Dapat Diubah Kedepannya.
                                                        <form method="get" action="{{ route('admin.hutang-piutang.debit-piutang.showBayarForm', $data->fakturjual->id_faktur_penjualan) }}">
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
                                                $jumlah += $data->kredit_penjualan;
                                            @endphp
                                        @endif
                                        @php
                                            $i++;
                                            $datautang[] = array('id_faktur' => $data->fakturjual->id_faktur_penjualan, 'qty' => $data->fakturjual->jualbuku->qty, 'judul_buku' => $data->fakturjual->jualbuku->indukbuku->judul_buku, 'tgl_transaksi' => $data->tgl_transaksi, 'harga_total' => $data->kredit_penjualan, 'status' => $data->fakturjual->status_bayar, 'is_obral' => $data->fakturjual->jualbuku->is_obral);
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No Faktur</th>
                                            <th>Pelanggan</th>
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
        var index = 0;
        function myFunction(id_penjualan, index_data) {
            id = id_penjualan
            index = index_data;
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
                        if(data.is_obral == 1){
                            trHTML += '<tr class="text-center"><td>' + data.id_faktur + '</td><td>' + data.qty + '</td><td>' + data.judul_buku + ' <p class="badge badge-warning">Obral</p>' + '</td><td>' + Date(data.tgl_transaksi).toString().substring(4,15) + '</td><td>' + formatter.format(data.harga_total) + '</td></tr>';
                        }else{
                            trHTML += '<tr class="text-center"><td>' + data.id_faktur + '</td><td>' + data.qty + '</td><td>' + data.judul_buku + '</td><td>' + Date(data.tgl_transaksi).toString().substring(4,15) + '</td><td>' + formatter.format(data.harga_total) + '</td></tr>';
                        }
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