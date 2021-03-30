@extends('layouts.base_website')

@section('title', 'Data Neraca Obor')
@section('laporankeuangan', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Neraca Saat Ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th class="w-25"></th>
                                        <th class="w-25">Debit</th>
                                        <th class="w-25">Kredit</th>
                                        <th class="w-25"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlah = 0;
                                    @endphp
                                    <tr class="data-row">
                                        <th class="w-25">Kas</th>
                                        <th class="w-25">{{ number_format($sumkas[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumkas[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumkas[0] - $sumkas[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumkas[0] - $sumkas[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Penjualan</th>
                                        <th class="w-25">{{ number_format($sumjual[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumjual[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumjual[0] - $sumjual[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumjual[0] - $sumjual[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Pembelian</th>
                                        <th class="w-25">{{ number_format($sumbeli[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumbeli[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumbeli[0] - $sumbeli[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumbeli[0] - $sumbeli[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Piutang</th>
                                        <th class="w-25">{{ number_format($sumpiutang[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumpiutang[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumpiutang[0] - $sumpiutang[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumpiutang[0] - $sumpiutang[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Hutang</th>
                                        <th class="w-25">{{ number_format($sumhutang[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumhutang[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumhutang[0] - $sumhutang[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumhutang[0] - $sumhutang[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Royalti</th>
                                        <th class="w-25">{{ number_format($sumroyalti[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumroyalti[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumroyalti[0] - $sumroyalti[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumroyalti[0] - $sumroyalti[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Retur Penjualan</th>
                                        <th class="w-25">{{ number_format($sumreturjual[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumreturjual[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumreturjual[0] - $sumreturjual[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumreturjual[0] - $sumreturjual[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Retur Pembelian</th>
                                        <th class="w-25">{{ number_format($sumreturbeli[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumreturbeli[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumreturbeli[0] - $sumreturbeli[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumreturbeli[0] - $sumreturbeli[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Pendapatan Lain-lain</th>
                                        <th class="w-25">{{ number_format($sumpendapatanlain[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumpendapatanlain[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumpendapatanlain[0] - $sumpendapatanlain[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumpendapatanlain[0] - $sumpendapatanlain[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th class="w-25">Beban Lain-lain</th>
                                        <th class="w-25">{{ number_format($sumbebanlain[0], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumbebanlain[1], 0, '', '.') }}</th>
                                        <th class="w-25">{{ number_format($sumbebanlain[0] - $sumbebanlain[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlah += ($sumbebanlain[0] - $sumbebanlain[1]);
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th colspan="3">Jumlah</th>
                                        <th class="w-25">{{ number_format($jumlah, 0, '', '.') }}</th>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="w-25"></th>
                                        <th class="w-25">Debit</th>
                                        <th class="w-25">Kredit</th>
                                        <th class="w-25"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Add rows table -->
@endsection