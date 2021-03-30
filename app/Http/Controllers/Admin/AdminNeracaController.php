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

class AdminNeracaController extends Controller
{
    public function sumpiutang($tgl_mulai, $tgl_selesai){
        $sumpiutang = [];
        $jurnaljual = JurnalJual::select('debit_piutang', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $jurnalumum = JurnalUmum::where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $kasmasuk = KasMasuk::select('kredit_piutang', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangKredit = array();
        $piutangDebit = array();
        $sumpiutang = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnaljual as $data){
            if($data->debit_piutang != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_piutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($jurnalumum as $data){
            if($data->tb_retur_penjualan_id != NULL){
                if($data->kredit_piutang != NULL && $data->returjual->jualbuku->status_penjualan == 1 && $data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk != NULL){
                    if($data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk->created_at > $data->created_at){
                        $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi_retur);
                    }
                }elseif($data->kredit_piutang != NULL && $data->returjual->jualbuku->status_penjualan == 1 && $data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk == NULL){
                    $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi_retur);
                }
            }elseif($data->tb_penjualan_buku_id != NULL && $data->debit_kredit_denda != NULL){
                $piutangKredit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
                $piutangDebit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        foreach($kasmasuk as $data){
            if($data->kredit_piutang != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        if(count($piutangDebit) >= count($piutangKredit)){
            $max = count($piutangDebit);
        }else{
            $max = count($piutangKredit);
        }

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumpiutang[0] = $sumDebit;
        $sumpiutang[1] = $sumKredit;
        
        return $sumpiutang;
    }

    public function sumpendapatanlain($tgl_mulai, $tgl_selesai){
        $kaslain = KasLain2::select('tb_kas_lain2.debit', 'tb_kas_lain2.kredit', 'tb_kas_lain2.tgl_transaksi')->
                    join('tb_data_account', 'tb_data_account.id_account', '=', 'tb_kas_lain2.tb_data_account_id')->
                    where('tb_data_account.aliran_kas', 'D')->
                    where('tb_kas_lain2.tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->
                    where('tb_kas_lain2.tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangKredit = array();
        $piutangDebit = array();
        $sumpendapatanlain = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($kaslain as $data){
            if($data->debit != 0){
                $piutangKredit[] = array('nominal' => $data->debit, 'tanggal' => $data->tgl_transaksi);
            }
            if($data->kredit != 0){
                $piutangDebit[] = array('nominal' => $data->kredit, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        if(count($piutangDebit) >= count($piutangKredit)){
            $max = count($piutangDebit);
        }else{
            $max = count($piutangKredit);
        }

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumpendapatanlain[0] = $sumDebit;
        $sumpendapatanlain[1] = $sumKredit;

        return $sumpendapatanlain;
    }

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

    public function sumhutang($tgl_mulai, $tgl_selesai){
        $jurnalbeli = JurnalBeli::select('kredit_hutang', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $jurnalumum = JurnalUmum::where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $kaskeluar = KasKeluar::select('debit_hutang', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangKredit = array();
        $piutangDebit = array();
        $sumhutang = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($jurnalbeli as $data){
            if($data->kredit_hutang != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_hutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($jurnalumum as $data){
            if($data->tb_retur_pembelian_id != NULL){
                if($data->debit_hutang != NULL && $data->returbeli->belibuku->status_pembelian == 1 && $data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar != NULL){
                    if($data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar->created_at > $data->created_at){
                        $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur);
                    }
                }elseif($data->debit_hutang != NULL && $data->returbeli->belibuku->status_pembelian == 1 && $data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar == NULL){
                    $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur);
                }
            }elseif($data->tb_pembelian_buku_id != NULL && $data->debit_kredit_denda != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
                $piutangKredit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        foreach($kaskeluar as $data){
            if($data->debit_hutang != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        if(count($piutangDebit) >= count($piutangKredit)){
            $max = count($piutangDebit);
        }else{
            $max = count($piutangKredit);
        }

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumhutang[0] = $sumDebit;
        $sumhutang[1] = $sumKredit;

        return $sumhutang;
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

    public function sumkas($tgl_mulai, $tgl_selesai){
        $kasmasuk = KasMasuk::where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $kaskeluar = KasKeluar::where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $jurnalumum = JurnalUmum::with(['returjual'])->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime($tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangDebit = array();
        $piutangKredit = array();
        $sumkas = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($kasmasuk as $data){
            if($data->debit_kas_masuk != NULL){
                if($data->fakturjual != NULL){
                    $piutangDebit[] = array('nominal' => $data->debit_kas_masuk, 'tanggal' => $data->tgl_transaksi, 'note' => $data->fakturjual->id_faktur_penjualan);
                }elseif($data->jurnaljual != NULL){
                    $piutangDebit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi, 'note' => $data->jurnaljual->fakturjual->id_faktur_penjualan);
                }else{
                    $piutangDebit[] = array('nominal' => $data->debit_kas_masuk, 'tanggal' => $data->tgl_transaksi, 'note' => $data->note);
                }
            }
        }
        foreach($kaskeluar as $data){
            if($data->kredit_kas_keluar != NULL){
                if($data->tb_terima_bukti_id != NULL){
                    $piutangKredit[] = array('nominal' => $data->kredit_kas_keluar, 'tanggal' => $data->tgl_transaksi, 'note' => $data->fakturbeli->id_faktur_pembelian);   
                }elseif($data->jurnalbeli != NULL){
                    $piutangKredit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi, 'note' => $data->jurnalbeli->fakturbeli->id_faktur_pembelian);   
                }else{
                    $piutangKredit[] = array('nominal' => $data->kredit_kas_keluar, 'tanggal' => $data->tgl_transaksi, 'note' => $data->note);   
                }
            }
        }
        foreach($jurnalumum as $data){
            if($data->tb_penjualan_buku_id == NULL){
                if($data->tb_retur_penjualan_id != NULL && ($data->returjual->jualbuku->fakturjual->kasmasuk || $data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk)){
                    if($data->returjual->jualbuku->fakturjual->kasmasuk){
                        $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->returjual->jualbuku->fakturjual->id_faktur_penjualan . " Retur");   
                    }elseif($data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk->updated_at < $data->updated_at){
                        $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->returjual->jualbuku->fakturjual->id_faktur_penjualan . " Retur");   
                    }
                }elseif($data->tb_retur_pembelian_id != NULL && ($data->returbeli->belibuku->fakturbeli->kaskeluar || $data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar)){
                    if($data->returbeli->belibuku->fakturbeli->kaskeluar != NULL){
                        $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->returbeli->belibuku->fakturbeli->id_faktur_pembelian . " Retur");   
                    }elseif($data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar->updated_at < $data->updated_at){
                        $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->returbeli->belibuku->fakturbeli->id_faktur_pembelian . " Retur");   
                    }
                }elseif($data->tb_pembelian_buku_id != NULL && $data->debit_kredit_denda != NULL){
                    $piutangKredit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->belibuku->fakturbeli->id_faktur_pembelian . " Denda");   
                    $piutangDebit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->belibuku->fakturbeli->id_faktur_pembelian . " Denda");   
                }
            }elseif($data->debit_kredit_royalti != NULL){
                $piutangKredit[] = array('nominal' => $data->debit_kredit_royalti, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->jualbuku->fakturjual->id_faktur_penjualan . " Royalti");   
            }else{
                $piutangKredit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->jualbuku->fakturjual->id_faktur_penjualan . " Denda");   
                $piutangDebit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur, 'note' => $data->jualbuku->fakturjual->id_faktur_penjualan . " Denda");   
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        if(count($piutangDebit) >= count($piutangKredit)){
            $max = count($piutangDebit);
        }else{
            $max = count($piutangKredit);
        }

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumkas[0] = $sumDebit;
        $sumkas[1] = $sumKredit;

        return $sumkas;
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
        $kaslain = KasLain2::select('tb_kas_lain2.kredit', 'tb_kas_lain2.debit', 'tb_kas_lain2.tgl_transaksi')->
                    join('tb_data_account', 'tb_data_account.id_account', '=', 'tb_kas_lain2.tb_data_account_id')->
                    where('tb_data_account.aliran_kas', 'K')->
                    where('tb_kas_lain2.tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->
                    where('tb_kas_lain2.tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $piutangDebit = array();
        $piutangKredit = array();
        $sumbebanlain = [];
        $sumDebit = 0;
        $sumKredit = 0;

        foreach($kaslain as $data){
            if($data->kredit != 0){
                $piutangDebit[] = array('nominal' => $data->kredit, 'tanggal' => $data->tgl_transaksi);
            }
            if($data->debit != 0){
                $piutangKredit[] = array('nominal' => $data->debit, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        if(count($piutangDebit) >= count($piutangKredit)){
            $max = count($piutangDebit);
        }else{
            $max = count($piutangKredit);
        }

        for($i = 0; $i < $max; $i++){
            if(!empty($piutangDebit[$i]['nominal'])){
                $sumDebit += $piutangDebit[$i]['nominal'];
            }
            if(!empty($piutangKredit[$i]['nominal'])){
                $sumKredit += $piutangKredit[$i]['nominal'];
            }
        }
        $sumbebanlain[0] = $sumDebit;
        $sumbebanlain[1] = $sumKredit;

        return $sumbebanlain;
    }

    public function index(Request $request){
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $sumkas = $this->sumkas($tgl_mulai, $tgl_selesai);
        $sumjual = $this->sumjual($tgl_mulai, $tgl_selesai);
        $sumbeli = $this->sumbeli($tgl_mulai, $tgl_selesai);
        $sumpiutang = $this->sumpiutang($tgl_mulai, $tgl_selesai);
        $sumhutang = $this->sumhutang($tgl_mulai, $tgl_selesai);
        $sumroyalti = $this->sumroyalti($tgl_mulai, $tgl_selesai);
        $sumreturjual = $this->sumreturjual($tgl_mulai, $tgl_selesai);
        $sumreturbeli = $this->sumreturbeli($tgl_mulai, $tgl_selesai);
        $sumpendapatanlain = $this->sumpendapatanlain($tgl_mulai, $tgl_selesai);
        $sumbebanlain = $this->sumbebanlain($tgl_mulai, $tgl_selesai);

        return view('Admin.LaporNeraca.index', compact(['sumkas', 'sumjual', 'sumbeli', 'sumpiutang', 'sumhutang', 'sumroyalti', 'sumreturjual', 'sumreturbeli', 'sumpendapatanlain', 'sumbebanlain']));
    }
}
