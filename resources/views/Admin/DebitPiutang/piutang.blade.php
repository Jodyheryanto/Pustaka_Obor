@extends('layouts.base_website')

@section('title', 'Laporan Piutang Obor')
@section('laporankeuangan', true)

@section('content')
    <!-- Add rows table -->
    <section id="add-row">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Piutang Saat Ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="w-50">Debit</th>
                                        <th colspan="2" class="w-50">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sumDebit = 0;
                                        $sumKredit = 0;
                                    @endphp
                                    @for($i = 0; $i < $max; $i++)
                                        <tr class="data-row">
                                            @if(!empty($piutangDebit[$i]['nominal']))
                                            <th class="w-25">{{ date('d M Y', strtotime($piutangDebit[$i]['tanggal'])) }}</th>
                                            <th class="w-25">{{ number_format($piutangDebit[$i]['nominal'], 0, '', '.') }}</th>
                                            @php
                                                $sumDebit += $piutangDebit[$i]['nominal'];
                                            @endphp
                                            @else
                                            <th class="w-25"></th>
                                            <th class="w-25"></th>
                                            @endif
                                            @if(!empty($piutangKredit[$i]['nominal']))
                                            <th class="w-25">{{ date('d M Y', strtotime($piutangKredit[$i]['tanggal'])) }}</th>
                                            <th class="w-25">{{ number_format($piutangKredit[$i]['nominal'], 0, '', '.') }}</th>
                                            @if(!empty($piutangKredit[$i]['note']))
                                            <th class="w-25">{{ $piutangKredit[$i]['note'] }}</th>
                                            @endif
                                            @php
                                                $sumKredit += $piutangKredit[$i]['nominal'];
                                            @endphp
                                            @else
                                            <th class="w-25"></th>
                                            <th class="w-25"></th>
                                            @endif
                                        </tr>
                                    @endfor
                                        <tr class="data-row">
                                            <th class="w-25">Jumlah Debit</th>
                                            <th class="w-25">{{ number_format($sumDebit, 0, '', '.') }}</th>
                                            <th class="w-25">Jumlah Kredit</th>
                                            <th class="w-25">{{ number_format($sumKredit, 0, '', '.') }}</th>
                                        </tr>
                                        <tr class="data-row">
                                            <th class="w-25"></th>
                                            <th class="w-25">Selisih</th>
                                            <th class="w-25">{{ number_format($sumDebit - $sumKredit, 0, '', '.') }}</th>
                                            <th class="w-25"></th>
                                        </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="w-50">Debit</th>
                                        <th colspan="2" class="w-50">Kredit</th>
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