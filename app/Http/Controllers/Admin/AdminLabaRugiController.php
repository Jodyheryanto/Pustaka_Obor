<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;
use App\Models\KasMasuk;
use App\Models\JurnalJual;
use App\Models\JurnalBeli;
use App\Models\JurnalUmum;
use App\Models\KasKeluar;
use App\Models\KasLain2;

class AdminLabaRugiController extends Controller
{
    public function sumjual($tgl_mulai, $tgl_selesai){
        $jurnaljual = JurnalJual::select('kredit_penjualan', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $kasmasuk = KasMasuk::select('kredit_penjualan', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangKredit = array();
        $sumjual = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnaljual as $data){
            if($data->kredit_penjualan != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_penjualan, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($kasmasuk as $data){
            if($data->kredit_penjualan != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_penjualan, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangKredit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumjual[0] = 0;
        $sumjual[1] = $sumKredit;

        return $sumjual;
    }

    public function sumpendapatanlain($tgl_mulai, $tgl_selesai){
        $kaslain = KasLain2::select('tb_kas_lain2.debit', 'tb_kas_lain2.tgl_transaksi')->
                    join('tb_data_account', 'tb_data_account.id_account', '=', 'tb_kas_lain2.tb_data_account_id')->
                    where('tb_data_account.aliran_kas', 'D')->
                    where('tb_kas_lain2.tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->
                    where('tb_kas_lain2.tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangKredit = array();
        $sumpendapatanlain = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($kaslain as $data){
            if($data->debit != 0){
                $piutangKredit[] = array('nominal' => $data->debit, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangKredit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumpendapatanlain[0] = 0;
        $sumpendapatanlain[1] = $sumKredit;

        return $sumpendapatanlain;
    }

    public function sumreturjual($tgl_mulai, $tgl_selesai){
        $jurnalumum = JurnalUmum::select('debit_retur_penjualan', 'tgl_transaksi_retur')->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangDebit = array();
        $sumreturjual = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnalumum as $data){
            if($data->debit_retur_penjualan != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_retur_penjualan, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
        }
        $sumreturjual[0] = $sumDebit;
        $sumreturjual[1] = 0;

        return $sumreturjual;
    }

    public function sumbeli($tgl_mulai, $tgl_selesai){
        $jurnalbeli = JurnalBeli::select('debit_pembelian', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $kaskeluar = KasKeluar::select('debit_pembelian', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangDebit = array();
        $sumbeli = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnalbeli as $data){
            if($data->debit_pembelian != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_pembelian, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($kaskeluar as $data){
            if($data->debit_pembelian != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_pembelian, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
        }
        $sumbeli[0] = $sumDebit;
        $sumbeli[1] = 0;

        return $sumbeli;
    }

    public function sumreturbeli($tgl_mulai, $tgl_selesai){
        $jurnalumum = JurnalUmum::select('kredit_retur_pembelian', 'tgl_transaksi_retur')->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangKredit = array();
        $sumreturbelli = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnalumum as $data){
            if($data->kredit_retur_pembelian != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_retur_pembelian, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangKredit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumreturbeli[0] = 0;
        $sumreturbeli[1] = $sumKredit;
        return $sumreturbeli;
    }

    public function sumroyalti($tgl_mulai, $tgl_selesai){
        $jurnalumum = JurnalUmum::select('debit_kredit_royalti', 'tgl_transaksi_retur')->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangDebit = array();
        $sumroyalti = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnalumum as $data){
            if($data->debit_kredit_royalti != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_kredit_royalti, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
        }
        $sumroyalti[0] = $sumDebit;
        $sumroyalti[1] = 0;

        return $sumroyalti;
    }

    public function sumbebanlain($tgl_mulai, $tgl_selesai){
        $kaslain = KasLain2::select('tb_kas_lain2.kredit', 'tb_kas_lain2.tgl_transaksi')->
                    join('tb_data_account', 'tb_data_account.id_account', '=', 'tb_kas_lain2.tb_data_account_id')->
                    where('tb_data_account.aliran_kas', 'K')->
                    where('tb_kas_lain2.tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->
                    where('tb_kas_lain2.tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangDebit = array();
        $sumbebanlain = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($kaslain as $data){
            if($data->kredit != 0){
                $piutangDebit[] = array('nominal' => $data->kredit, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
        }
        $sumbebanlain[0] = $sumDebit;
        $sumbebanlain[1] = 0;

        return $sumbebanlain;
    }

    public function index(Request $request){
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $sumjual = $this->sumjual($tgl_mulai, $tgl_selesai);
        $sumbeli = $this->sumbeli($tgl_mulai, $tgl_selesai);
        $sumroyalti = $this->sumroyalti($tgl_mulai, $tgl_selesai);
        $sumreturjual = $this->sumreturjual($tgl_mulai, $tgl_selesai);
        $sumreturbeli = $this->sumreturbeli($tgl_mulai, $tgl_selesai);
        $sumpendapatanlain = $this->sumpendapatanlain($tgl_mulai, $tgl_selesai);
        $sumbebanlain = $this->sumbebanlain($tgl_mulai, $tgl_selesai);

        return view('Admin.LaporLabaRugi.index', compact(['sumjual', 'sumbeli', 'sumroyalti', 'sumreturjual', 'sumreturbeli', 'sumpendapatanlain', 'sumbebanlain']));
    }
}
