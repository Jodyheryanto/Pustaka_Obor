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
use App\Models\JurnalUmum;
use App\Models\KasKeluar;

class AdminKasController extends Controller
{
    function index(Request $request){
        $kasmasuk = KasMasuk::with(['fakturjual', 'jurnaljual'])->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->tgl_selesai)))->get();
        $kaskeluar = KasKeluar::with(['fakturbeli', 'jurnalbeli'])->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->tgl_selesai)))->get();
        $jurnalumum = JurnalUmum::with(['returjual', 'returbeli'])->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $request->tgl_mulai)))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime($request->tgl_selesai)))->get();
        $piutangDebit = array();
        $piutangKredit = array();

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
                    if($data->returjual->jualbuku->fakturjual->kasmasuk != NULL){
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
        
        return view('Admin.LaporKas.index', compact(['piutangDebit', 'piutangKredit', 'max']));
    }
}
