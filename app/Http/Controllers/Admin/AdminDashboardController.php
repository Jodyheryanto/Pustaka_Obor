<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\BeliBuku;
use App\Models\ReturBeli;
use App\Models\JualBuku;
use App\Models\ReturJual;
use App\Models\FakturJual;

class AdminDashboardController extends Controller
{
    public function index()
	{
        $belibuku = BeliBuku::count();
        $databeli = BeliBuku::orderBy('created_at', 'desc')->limit(7)->get();
        $datajual = JualBuku::orderBy('created_at', 'desc')->limit(7)->get();
        $datareturbeli = ReturBeli::orderBy('created_at', 'desc')->limit(7)->get();
        $datareturjual = ReturJual::orderBy('created_at', 'desc')->limit(7)->get();
        $jualbuku = JualBuku::count();
        $returjual = ReturJual::count();
        $returbeli = ReturBeli::count();
        $year = date('Y');
        $laporpenjualan = array(array("bulan" => "Januari", "value" => 0),
                            array("bulan" => "Februari", "value" => 0),
                            array("bulan" => "Maret", "value" => 0),
                            array("bulan" => "April", "value" => 0),
                            array("bulan" => "Mei", "value" => 0),
                            array("bulan" => "Juni", "value" => 0),
                            array("bulan" => "Juli", "value" => 0),
                            array("bulan" => "Agustus", "value" => 0),
                            array("bulan" => "September", "value" => 0),
                            array("bulan" => "Oktober", "value" => 0),
                            array("bulan" => "November", "value" => 0),
                            array("bulan" => "Desember", "value" => 0)
                        );
        $penjualanbulan = JualBuku::where(DB::raw("YEAR(created_at)"), date('Y'))->get();
        // var_dump($laporpenjualan);
        $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $i = 0;
        foreach ($bulan as $data) {
            $jualbulan = 0;
            foreach ($penjualanbulan as $data2) {
                if(date('Y-m', strtotime($year.'-'.$data)) == date('Y-m', strtotime($data2->created_at))){
                    $laporpenjualan[$i]['value'] += $data2->harga_total;
                }
            }
        $i++;
        }
        $terbayar = FakturJual::select(DB::raw('sum(tb_penjualan_buku.harga_total) as `harga_total`'))
                        ->join('tb_penjualan_buku','tb_faktur_penjualan.tb_penjualan_buku_id','=','tb_penjualan_buku.id_penjualan_buku')
                        ->where(DB::raw("YEAR(tb_penjualan_buku.created_at)"), date('Y'))->where('tb_faktur_penjualan.status_bayar', 1)->first();
        $piutang = FakturJual::select(DB::raw('sum(tb_penjualan_buku.harga_total) as `harga_total`'))
                        ->join('tb_penjualan_buku','tb_faktur_penjualan.tb_penjualan_buku_id','=','tb_penjualan_buku.id_penjualan_buku')
                        ->where(DB::raw("YEAR(tb_penjualan_buku.created_at)"), date('Y'))->where('tb_faktur_penjualan.status_bayar', 0)->first();
        return view('dashboard', compact(['belibuku', 'jualbuku', 'returjual', 'returbeli', 'laporpenjualan', 'terbayar', 'piutang', 'databeli', 'datajual', 'datareturbeli', 'datareturjual']));
    }
}
