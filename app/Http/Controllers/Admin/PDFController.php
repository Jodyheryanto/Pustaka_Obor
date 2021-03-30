<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DateTime;
use DB;
use App\Models\Pelanggan;
use App\Models\Salesman;
use App\Models\Pengarang;
use App\Models\ReturBeli;
use App\Models\ReturJual;
use App\Models\BeliBuku;
use App\Models\IndukBuku;
use App\Models\JualBuku;
use App\Models\Stok;
use App\Models\Histori;
use \stdClass;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Untuk Kartu Stok
    public function downkartustok(Request $request)
    {
        $histori = Histori::with(['returjual', 'returbeli', 'belibuku', 'jualbuku'])->get();
        $myArray = array();

        foreach($histori as $buku){
            if($buku->tb_pembelian_buku_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->belibuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->belibuku->updated_at){
                    $myArray[] = array('status' => 'belibuku', 'kode_buku' => $buku->belibuku->indukbuku->kode_buku, 'judul_buku' => $buku->belibuku->indukbuku->judul_buku, 'pengarang' => $buku->belibuku->indukbuku->pengarang->nm_pengarang, 'isbn' => $buku->belibuku->indukbuku->isbn, 'kategori' => $buku->belibuku->indukbuku->kategori->nama, 'penerbit' => $buku->belibuku->indukbuku->penerbit->nm_penerbit, 'distributor' => $buku->belibuku->indukbuku->distributor->nm_distributor, 'penerjemah' => $buku->belibuku->indukbuku->penerjemah->nm_penerjemah, 'tahun_terbit' => $buku->belibuku->indukbuku->tahun_terbit, 'deskripsi' => $buku->belibuku->indukbuku->deskripsi_buku, 'qtykeluar' => '', 'qtymasuk' => $buku->belibuku->qty, 'entitas' => $buku->belibuku->supplier->nm_supplier, 'qtyawal' => $buku->stok_awal, 'qtyakhir' => $buku->belibuku->qty + $buku->stok_awal, 'tgl_transaksi' => $buku->belibuku->updated_at);
                }
            }else if($buku->tb_penjualan_buku_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->jualbuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->jualbuku->updated_at){
                    $myArray[] = array('status' => 'jualbuku', 'kode_buku' => $buku->jualbuku->indukbuku->kode_buku, 'judul_buku' => $buku->jualbuku->indukbuku->judul_buku, 'pengarang' => $buku->jualbuku->indukbuku->pengarang->nm_pengarang, 'isbn' => $buku->jualbuku->indukbuku->isbn, 'kategori' => $buku->jualbuku->indukbuku->kategori->nama, 'penerbit' => $buku->jualbuku->indukbuku->penerbit->nm_penerbit, 'distributor' => $buku->jualbuku->indukbuku->distributor->nm_distributor, 'penerjemah' => $buku->jualbuku->indukbuku->penerjemah->nm_penerjemah, 'tahun_terbit' => $buku->jualbuku->indukbuku->tahun_terbit, 'deskripsi' => $buku->jualbuku->indukbuku->deskripsi_buku, 'qtykeluar' => $buku->jualbuku->qty, 'qtymasuk' => '', 'entitas' => $buku->jualbuku->pelanggan->nama, 'qtyawal' => $buku->stok_awal, 'qtyakhir' => $buku->stok_awal - $buku->jualbuku->qty, 'tgl_transaksi' => $buku->jualbuku->updated_at);
                }
            }else if($buku->tb_retur_penjualan_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->returjual->jualbuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->returjual->jualbuku->updated_at){
                    $myArray[] = array('status' => 'returjual', 'kode_buku' => $buku->returjual->jualbuku->indukbuku->kode_buku, 'judul_buku' => $buku->returjual->jualbuku->indukbuku->judul_buku, 'pengarang' => $buku->returjual->jualbuku->indukbuku->pengarang->nm_pengarang, 'isbn' => $buku->returjual->jualbuku->indukbuku->isbn, 'kategori' => $buku->returjual->jualbuku->indukbuku->kategori->nama, 'penerbit' => $buku->returjual->jualbuku->indukbuku->penerbit->nm_penerbit, 'distributor' => $buku->returjual->jualbuku->indukbuku->distributor->nm_distributor, 'penerjemah' => $buku->returjual->jualbuku->indukbuku->penerjemah->nm_penerjemah, 'tahun_terbit' => $buku->returjual->jualbuku->indukbuku->tahun_terbit, 'deskripsi' => $buku->returjual->jualbuku->indukbuku->deskripsi_buku, 'qtykeluar' => '', 'qtymasuk' => $buku->returjual->qty, 'entitas' => $buku->returjual->jualbuku->pelanggan->name, 'qtyawal' => $buku->stok_awal, 'qtyakhir' => $buku->stok_awal + $buku->returjual->jualbuku->qty, 'tgl_transaksi' => $buku->returjual->updated_at);
                }
            }else if($buku->tb_retur_pembelian_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->returbeli->belibuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->returbeli->belibuku->updated_at){
                    $myArray[] = array('status' => 'returbeli', 'kode_buku' => $buku->returbeli->belibuku->indukbuku->kode_buku, 'judul_buku' => $buku->returbeli->belibuku->indukbuku->judul_buku, 'pengarang' => $buku->returbeli->belibuku->indukbuku->pengarang->nm_pengarang, 'isbn' => $buku->returbeli->belibuku->indukbuku->isbn, 'kategori' => $buku->returbeli->belibuku->indukbuku->kategori->nama, 'penerbit' => $buku->returbeli->belibuku->indukbuku->penerbit->nm_penerbit, 'distributor' => $buku->returbeli->belibuku->indukbuku->distributor->nm_distributor, 'penerjemah' => $buku->returbeli->belibuku->indukbuku->penerjemah->nm_penerjemah, 'tahun_terbit' => $buku->returbeli->belibuku->indukbuku->tahun_terbit, 'deskripsi' => $buku->returbeli->belibuku->indukbuku->deskripsi_buku, 'qtykeluar' => $buku->returbeli->qty, 'qtymasuk' => '', 'entitas' => $buku->returbeli->belibuku->supplier->nm_supplier, 'qtyawal' => $buku->stok_awal, 'qtyakhir' => $buku->stok_awal - $buku->returbeli->belibuku->qty, 'tgl_transaksi' => $buku->returbeli->updated_at);
                }
            }
        }
        usort($myArray, function($a, $b) {
            return $a['kode_buku'] <=> $b['kode_buku'];
        });
        usort($myArray, function($a, $b) {
            return $a['tgl_transaksi'] <=> $b['tgl_transaksi'];
        });
        // var_dump($myArray);
        $buku = array();
        $i = -1;
        foreach($myArray as $data){
            if($i === -1){
                $buku[] = array('kode_buku' => $data['kode_buku'], 'isbn' => $data['isbn'], 'kategori' => $data['kategori'], 'judul_buku' => $data['judul_buku'], 'pengarang' => $data['pengarang'], 'penerbit' => $data['penerbit'], 'distributor' => $data['distributor'], 'penerjemah' => $data['penerjemah'], 'tahun_terbit' => $data['tahun_terbit'], 'deskripsi' => $data['deskripsi']);
                $i++;
            }
            if($buku[$i]['kode_buku'] !== $data['kode_buku']){
                $buku[] = array('kode_buku' => $data['kode_buku'], 'isbn' => $data['isbn'], 'kategori' => $data['kategori'], 'judul_buku' => $data['judul_buku'], 'pengarang' => $data['pengarang'], 'penerbit' => $data['penerbit'], 'distributor' => $data['distributor'], 'penerjemah' => $data['penerjemah'], 'tahun_terbit' => $data['tahun_terbit'], 'deskripsi' => $data['deskripsi']);
                $i++;
            }
        }
        $view = false;
    
        $pdf = PDF::loadView('Admin.PDF_Base.datastock', compact(['myArray', 'buku', 'view']));

        return $pdf->download('Laporan_Stok.pdf');
    }

    public function showkartustok(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);

        $indukbuku = IndukBuku::with(['stock', 'histori', 'pengarang', 'distributor', 'penerjemah', 'kategori', 'penerbit'])->get();
        $databuku = array();
        $value = 0;
        foreach($indukbuku as $data){
            if(count($data->histori) > 0 && $value == 0){
                $databuku[] = array('kode_buku' => $data->kode_buku);
                $value = 1;
            }
            $value = 0;
        }

        return view('Admin.PDF_Base.datastock', compact(['indukbuku', 'databuku']));
    }

    //Untuk persediaan
    public function downpersediaan(Request $request)
    {
        $indukbuku = IndukBuku::with(['stock', 'histori'])->get();
        $myArray = array();

        foreach($histori as $buku){
            if($buku->tb_pembelian_buku_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->belibuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->belibuku->updated_at){
                    $myArray[] = array('status' => 'belibuku', 'kode_buku' => $buku->belibuku->indukbuku->kode_buku, 'judul_buku' => $buku->belibuku->indukbuku->judul_buku, 'qtymasuk' => $buku->belibuku->qty, 'tgl_transaksi' => $buku->belibuku->updated_at);
                }
            }else if($buku->tb_penjualan_buku_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->jualbuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->jualbuku->updated_at){
                    $myArray[] = array('status' => 'jualbuku', 'kode_buku' => $buku->jualbuku->indukbuku->kode_buku, 'judul_buku' => $buku->jualbuku->indukbuku->judul_buku, 'qtykeluar' => $buku->jualbuku->qty, 'tgl_transaksi' => $buku->jualbuku->updated_at);
                }
            }else if($buku->tb_retur_penjualan_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->returjual->jualbuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->returjual->jualbuku->updated_at){
                    $myArray[] = array('status' => 'returjual', 'kode_buku' => $buku->returjual->jualbuku->indukbuku->kode_buku, 'judul_buku' => $buku->returjual->jualbuku->indukbuku->judul_buku, 'qtymasuk' => $buku->returjual->qty, 'tgl_transaksi' => $buku->returjual->updated_at);
                }
            }else if($buku->tb_retur_pembelian_id !== NULL){
                if($request->session()->get('tgl_mulai') <= $buku->returbeli->belibuku->updated_at && $request->session()->get('tgl_selesai') >= $buku->returbeli->belibuku->updated_at){
                    $myArray[] = array('status' => 'returbeli', 'kode_buku' => $buku->returbeli->belibuku->indukbuku->kode_buku, 'judul_buku' => $buku->returbeli->belibuku->indukbuku->judul_buku, 'qtykeluar' => $buku->returbeli->qty, 'tgl_transaksi' => $buku->returbeli->updated_at);
                }
            }
        }
        usort($myArray, function($a, $b) {
            return $a['kode_buku'] <=> $b['kode_buku'];
        });
        $buku = array();
        $i = -1;
        foreach($myArray as $data){
            if($i === -1){
                $buku[] = array('kode_buku' => $data['kode_buku'], 'judul_buku' => $data['judul_buku']);
                $i++;
            }
            if($buku[$i]['kode_buku'] !== $data['kode_buku']){
                $buku[] = array('kode_buku' => $data['kode_buku'], 'judul_buku' => $data['judul_buku']);
                $i++;
            }
        }
        $countArr = array();
        foreach($buku as $data){
            $sumbeli = 0;
            $sumjual = 0;
            $sumreturjual = 0;
            $sumreturbeli = 0;
            foreach($myArray as $data2){
                if($data['kode_buku'] === $data2['kode_buku']){
                    if($data2['status'] === 'belibuku'){
                        $sumbeli += $data2['qtymasuk'];
                    }else if($data2['status'] === 'jualbuku'){
                        $sumjual += $data2['qtykeluar'];
                    }else if($data2['status'] === 'returjual'){ 
                        $sumreturjual += $data2['qtymasuk'];
                    }else{
                        $sumreturbeli += $data2['qtykeluar'];
                    }
                }
            }
            $countArr[] = array('kode_buku' => $data['kode_buku'], 'judul_buku' => $data['judul_buku'], 'belibuku' => $sumbeli, 'jualbuku' => $sumjual, 'returbeli' => $sumreturbeli, 'returjual' => $sumreturjual);
        }
        $view = false;
        $pdf = PDF::loadView('Admin.PDF_Base.persediaan', compact(['countArr', 'indukbuku', 'view']));

        return $pdf->download('Laporan_Persediaan.pdf');
    }

    public function showpersediaan(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        $indukbuku = IndukBuku::with(['stock', 'sumjual', 'sumbeli', 'sumreturbeli', 'sumreturbeli', 'sumterima', 'sumtitip'])->get();

        return view('Admin.PDF_Base.persediaan', compact(['indukbuku']));
    }

    //Untuk royalti penulis
    public function downroyalti()
    {
        $pengarang = Pengarang::with(['indukbuku'])->get();
        $view = false;
    
        $pdf = PDF::loadView('Admin.PDF_Base.royalti', compact(['pengarang', 'view']));

        return $pdf->download('Laporan_Royalti.pdf');
    }

    public function showroyalti(Request $request)
    {
        $pengarang = Pengarang::with(['indukbuku'])->get();
        $datajual = array();
        $value = 0;
        foreach($pengarang as $data){
            foreach($data->indukbuku as $data2){
                if(count($data2->jualdetail) > 0 && $value == 0){
                    $datajual[] = array('id_pengarang' => $data->id_pengarang);
                    $value = 1;
                }
            }
            $value = 0;
        }
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        $view = true;
        return view('Admin.PDF_Base.royalti', compact(['pengarang', 'datajual', 'view']));
    }

    public function downsalesman()
    {
        $salesman = Salesman::with(['jualbuku'])->get();
        $view = false;
    
        $pdf = PDF::loadView('Admin.PDF_Base.analisa_salesman', compact(['salesman', 'view']));

        return $pdf->download('Laporan_Salesman.pdf');
    }

    public function showsalesman(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        $salesman = Salesman::with(['jualbuku'])->get();
        $view = true;
        return view('Admin.PDF_Base.analisa_salesman', compact(['salesman', 'view']));
    }

    public function downpelanggan()
    {
        $pelanggan = Pelanggan::with(['jualbuku'])->get();
        $view = false;
        $pdf = PDF::loadView('Admin.PDF_Base.analisa_pelanggan', compact(['pelanggan', 'view']));

        return $pdf->download('Laporan_Pelanggan.pdf');
    }

    public function showpelanggan(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        $pelanggan = Pelanggan::with(['jualbuku'])->get();
        $view = true;
        return view('Admin.PDF_Base.analisa_pelanggan', compact(['pelanggan', 'view']));
    }
}
