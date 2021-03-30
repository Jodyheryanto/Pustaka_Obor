@extends('layouts.base_website')

@section('title', 'Pembayaran Hutang Buku')
@section('debithutang', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pembayaran Hutang</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.hutang-piutang.debit-hutang.bayar') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="fakturCount" value="{{ $fakturCount }}">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ISBN</th>
                                            <th>Jumlah</th>
                                            <th>Judul Buku</th>
                                            <th>Harga Satuan</th>
                                            <th>Harga Akhir</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php 
                                            $i = 0;
                                            $sumqty = 0;
                                            $sumharga = 0;
                                        @endphp
                                        @foreach($faktur as $data)
                                        @php
                                            $tanggal = $data->belibuku->updated_at;
                                        @endphp
                                        <tr style="text-align: center;">
                                            <input type="hidden" name="id_jurnal[{{ $i }}]" value="{{ $data->jurnalbeli->kode_jurnal_pembelian }}">
                                            <input type="hidden" name="id_faktur[{{ $i }}]" value="{{ $data->id }}">
                                            <input type="hidden" name="id_pembelian_buku[{{ $i }}]" value="{{ $data->belibuku->id_pembelian_buku }}">
                                            <input type="hidden" name="debit_hutang[{{ $i }}]" value="{{ $data->belibuku->total_harga }}">
                                            <input type="hidden" name="kode_buku[{{ $i }}]" value="{{ $data->belibuku->indukbuku->kode_buku }}">
                                            <th>{{ $i + 1 }}</th>
                                            <th>{{ $data->belibuku->indukbuku->isbn }}</th>
                                            @if($data->belibuku->returbeli != NULL)
                                            <th>{{ $data->belibuku->qty }} ({{ $data->belibuku->returbeli->qtyretur }})</th>
                                            <input type="hidden" name="qty[{{ $i }}]" value="{{ $data->belibuku->qty - $data->belibuku->returbeli->qtyretur }}">
                                            @else
                                            <th>{{ $data->belibuku->qty }} (0)</th>
                                            <input type="hidden" name="qty[{{ $i }}]" value="{{ $data->belibuku->qty }}">
                                            @endif
                                            <th>{{ $data->belibuku->indukbuku->judul_buku }}</th>
                                            <th>Rp {{ number_format($data->belibuku->harga_beli_satuan, 0, '', '.') }}</th>
                                            @if($data->belibuku->returbeli != NULL)
                                            <th><div class="controls"><select class="form-control"  name="harga_bayar[{{ $i }}]" onchange="total_prize({{ $i }})">
                                                    <option value="{{ $data->belibuku->total_harga - ($data->belibuku->returbeli->qtyretur * $data->belibuku->harga_beli_satuan) }}">Rp {{ number_format($data->belibuku->total_harga - ($data->belibuku->returbeli->qtyretur * $data->belibuku->harga_beli_satuan), 0, '', '.') }}</option>
                                                    <option value="0">Rp 0</option>
                                                </select></div></th>
                                            @else
                                            <th><div class="controls"><select class="form-control"  name="harga_bayar[{{ $i }}]" onchange="total_prize({{ $i }})">
                                                    <option value="{{ $data->belibuku->total_harga }}">Rp {{ number_format($data->belibuku->total_harga, 0, '', '.') }}</option>
                                                    <option value="0">Rp 0</option>
                                                </select></div></th>
                                            @endif
                                        </tr>
                                        @php 
                                            $i++;
                                            if($data->belibuku->returbeli != NULL){
                                                $sumqty += $data->belibuku->qty - $data->belibuku->returbeli->qtyretur;
                                                $sumharga += $data->belibuku->total_harga - ($data->belibuku->harga_beli_satuan * $data->belibuku->returbeli->qtyretur);
                                            }else{
                                                $sumqty += $data->belibuku->qty;
                                                $sumharga += $data->belibuku->total_harga;
                                            }
                                        @endphp
                                        @endforeach

                                        <tr style="text-align: center;">
                                            <th colspan="2">Jumlah
                                                Total</th>
                                            <th>{{ $sumqty }}</th>
                                            <th colspan="2">Denda</th>
                                            <th>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="denda" name="denda" value="0">
                                                </div>
                                            </th>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <th colspan="2"></th>
                                            <th></th>
                                            <th colspan="2">Total
                                                Harga</th>
                                            <th><div id="total_harga">Rp. {{ number_format($sumharga, 0, '', '.') }}</div></th>
                                        </tr>
                                    </tbody>
                                </table>
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
@section('page-js')
    <script>
        function total_prize(index) {
            var jumlah_harga = 0;
            var formatter = new Intl.NumberFormat('id-ID');
            var denda = $('#denda').val();
            $('div.controls select').each(function(){
                jumlah_harga += parseInt($(this).val());
            })
            jumlah_harga += parseInt(denda);
            $('#total_harga').text('Rp. '+formatter.format(jumlah_harga));
        }
    </script>
    <script>
        $("#denda").keyup(function() {
            var jumlah_harga = 0;
            var formatter = new Intl.NumberFormat('id-ID');
            var denda = 0;
            if($(this).val() != ''){
                denda = parseInt($(this).val());
            }
            $('div.controls select').each(function(){
                jumlah_harga += parseInt($(this).val());
            })
            jumlah_harga += parseInt(denda);
            $('#total_harga').text('Rp. '+formatter.format(jumlah_harga));
        });
    </script>
@endsection