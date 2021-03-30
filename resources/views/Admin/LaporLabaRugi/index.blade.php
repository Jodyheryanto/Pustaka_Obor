@extends('layouts.base_website')

@section('title', 'Data Laba Rugi Obor')
@section('laporankeuangan', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Laba Rugi Saat Ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlahpendapatan = 0;
                                        $jumlahbeban = 0;
                                    @endphp
                                    <tr class="data-row">
                                        <th>Penjualan</th>
                                        <th>{{ number_format($sumjual[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlahpendapatan += $sumjual[1];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th>Retur Pembelian</th>
                                        <th>{{ number_format($sumreturbeli[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlahpendapatan += $sumreturbeli[1];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th>Pendapatan Lain-lain</th>
                                        <th>{{ number_format($sumpendapatanlain[1], 0, '', '.') }}</th>
                                        @php
                                            $jumlahpendapatan += $sumpendapatanlain[1];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th style="border-top: thin solid;">Jumlah Laba Kotor</th>
                                        <th style="border-top: thin solid;">{{ number_format($jumlahpendapatan, 0, '', '.') }}</th>
                                    </tr>
                                    <tr class="data-row">
                                        <th>Pembelian</th>
                                        <th>{{ number_format($sumbeli[0], 0, '', '.') }}</th>
                                        @php
                                            $jumlahbeban += $sumbeli[0];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th>Royalti</th>
                                        <th>{{ number_format($sumroyalti[0], 0, '', '.') }}</th>
                                        @php
                                            $jumlahbeban += $sumroyalti[0];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th>Retur Penjualan</th>
                                        <th>{{ number_format($sumreturjual[0], 0, '', '.') }}</th>
                                        @php
                                            $jumlahbeban += $sumreturjual[0];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th>Beban Lain-lain</th>
                                        <th>{{ number_format($sumbebanlain[0], 0, '', '.') }}</th>
                                        @php
                                            $jumlahbeban += $sumbebanlain[0];
                                        @endphp
                                    </tr>
                                    <tr class="data-row">
                                        <th style="border-top: thin solid;">Jumlah Laba Bersih</th>
                                        <th style="border-top: thin solid;">{{ number_format($jumlahpendapatan - $jumlahbeban, 0, '', '.') }}</th>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Jumlah</th>
                                        <th></th>
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