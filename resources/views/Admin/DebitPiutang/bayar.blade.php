@extends('layouts.base_website')

@section('title', 'Pembayaran Piutang Buku')
@section('debitpiutang', true)

@section('content')
    <!-- Input Validation start -->
    <section class="input-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pembayaran Piutang</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.hutang-piutang.debit-piutang.bayar') }}" method="POST" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="fakturCount" value="{{ $fakturCount }}">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ISBN</th>
                                            <th>Qty (Retur)</th>
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
                                            $tanggal = $data->jualbuku->updated_at;
                                        @endphp
                                        <tr style="text-align: center;">
                                            <input type="hidden" name="id_jurnal[{{ $i }}]" value="{{ $data->jurnaljual->kode_jurnal_penjualan }}">
                                            <input type="hidden" name="id_faktur[{{ $i }}]" value="{{ $data->id }}">
                                            <input type="hidden" name="id_penjualan_buku[{{ $i }}]" value="{{ $data->jualbuku->id_penjualan_buku }}">
                                            <input type="hidden" name="kredit_piutang[{{ $i }}]" value="{{ $data->jualbuku->harga_total }}">
                                            <input type="hidden" name="total_non_diskon[{{ $i }}]" value="{{ $data->jualbuku->total_non_diskon }}">
                                            <input type="hidden" name="kode_buku[{{ $i }}]" value="{{ $data->jualbuku->indukbuku->kode_buku }}">
                                            <th>{{ $i + 1 }}</th>
                                            <th>{{ $data->jualbuku->indukbuku->isbn }}</th>
                                            @if($data->jualbuku->returjual != NULL)
                                            <input type="hidden" name="qty[{{ $i }}]" value="{{ $data->jualbuku->qty - $data->jualbuku->returjual->qtyretur }}">
                                            <th>{{ $data->jualbuku->qty }} ({{ $data->jualbuku->returjual->qtyretur }})</th>
                                            @else
                                            <input type="hidden" name="qty[{{ $i }}]" value="{{ $data->jualbuku->qty }}">
                                            <th>{{ $data->jualbuku->qty }} (0)</th>
                                            @endif
                                            <th>{{ $data->jualbuku->indukbuku->judul_buku }} @if($data->jualbuku->is_obral == 1) <p class="badge badge-warning">Obral</p> @endif</th>
                                            <th>Rp {{ number_format($data->jualbuku->harga_jual_satuan, 0, '', '.') }}</th>
                                            @if($data->jualbuku->returjual != NULL)
                                            <input type="hidden" name="total_retur[{{ $i }}]" value="{{ $data->jualbuku->returjual->total_non_diskon }}">
                                            <th><div class="controls"><select class="form-control"  name="harga_bayar[{{ $i }}]" onchange="total_prize({{ $i }})">
                                                    <option value="{{ $data->jualbuku->harga_total - $data->jualbuku->returjual->total_harga }}">Rp {{ number_format($data->jualbuku->harga_total - $data->jualbuku->returjual->total_harga, 0, '', '.') }}</option>
                                                    <option value="0">Rp 0</option>
                                                </select>
                                            </div></th>
                                            @else
                                            <input type="hidden" name="total_retur[{{ $i }}]" value="0">
                                            <th><div class="controls"><select class="form-control"  name="harga_bayar[{{ $i }}]" onchange="total_prize({{ $i }})">
                                                <option value="{{ $data->jualbuku->harga_total }}">Rp {{ number_format($data->jualbuku->harga_total, 0, '', '.') }}</option>
                                                <option value="0">Rp 0</option>
                                            </select></div></th>
                                            @endif
                                        </tr>
                                        @php 
                                            $i++;
                                            if($data->jualbuku->returjual != NULL){
                                                $sumqty += $data->jualbuku->qty - $data->jualbuku->returjual->qtyretur;
                                                $sumharga += $data->jualbuku->harga_total - $data->jualbuku->returjual->total_harga;
                                            }else{
                                                $sumqty += $data->jualbuku->qty;
                                                $sumharga += $data->jualbuku->harga_total;
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
                                            <th colspan="2">Ongkos Kirim</th>
                                            <th>Rp. {{ number_format($ongkir, 0, '', '.') }}</th>
                                            <input type="hidden" id="ongkir" value="{{ $ongkir }}">
                                        </tr>
                                        <tr style="text-align: center;">
                                            <th colspan="2"></th>
                                            <th></th>
                                            <th colspan="2">Total
                                                Harga</th>
                                            <th><div id="total_harga">Rp. {{ number_format($sumharga + $ongkir, 0, '', '.') }}</div></th>
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
            var denda = parseInt($('#denda').val());
            var ongkir = parseInt($('#ongkir').val());
            $('div.controls select').each(function(){
                jumlah_harga += parseInt($(this).val());
            })
            jumlah_harga += parseInt(denda + ongkir);
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
            var ongkir = parseInt($('#ongkir').val());
            $('div.controls select').each(function(){
                jumlah_harga += parseInt($(this).val());
            })
            jumlah_harga += parseInt(denda + ongkir);
            $('#total_harga').text('Rp. '+formatter.format(jumlah_harga));
        });
    </script>
@endsection
