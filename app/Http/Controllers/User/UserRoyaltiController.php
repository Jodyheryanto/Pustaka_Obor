<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\Pengarang;
use App\Models\IndukBuku;
use App\Models\BatasanWaktu;

class UserRoyaltiController extends Controller
{
    public function index()
	{
        return view('User.index');
    }

    public function list_buku(Request $request){
        $batasan = BatasanWaktu::where('id', 1)->first();
        $request->session()->put('tgl_mulai', date('Y-m-d', strtotime($batasan->tanggal_mulai)));
        $request->session()->put('tgl_selesai', date('Y-m-d', strtotime($batasan->tanggal_selesai)));
        $semester = date('Y-m', strtotime($batasan->tanggal_mulai));
        $pengarang = Pengarang::with(['indukbuku'])->where('NIK', $request->nik)->first();
        if($pengarang != NULL && $pengarang->indukbuku != NULL){
            return view('User.list_buku', compact(['pengarang', 'semester']));
        }else{
            return redirect()->route('user.not-found');
        }
    }

    public function api_list_buku(Request $request){
        $batasan = BatasanWaktu::where('id', 1)->first();
        $request->session()->put('tgl_mulai', date('Y-m-d', strtotime($batasan->tanggal_mulai)));
        $request->session()->put('tgl_selesai', date('Y-m-d', strtotime($batasan->tanggal_selesai)));
        $pengarang = Pengarang::with(['indukbuku'])->where('NIK', $request->nik)->first();
        if($pengarang != NULL && $pengarang->indukbuku != NULL){
            return $pengarang;
        }else{
            return 0;
        }
    }

    public function grafik_royalti($id, Request $request){
        $batasan = BatasanWaktu::where('id', 1)->first();
        $request->session()->put('tgl_mulai', date('Y-m-d', strtotime($batasan->tanggal_mulai)));
        $request->session()->put('tgl_selesai', date('Y-m-d', strtotime($batasan->tanggal_selesai)));
        $semester = date('Y-m', strtotime($batasan->tanggal_mulai));
        $indukbuku = IndukBuku::with(['jualdetail', 'jualbuku', 'pengarang'])->where('kode_buku', $id)->first();
        return view('User.grafik_royalti', compact(['indukbuku', 'semester']));
    }

    public function api_grafik_royalti(Request $request){
        $batasan = BatasanWaktu::where('id', 1)->first();
        $request->session()->put('tgl_mulai', date('Y-m-d', strtotime($batasan->tanggal_mulai)));
        $request->session()->put('tgl_selesai', date('Y-m-d', strtotime($batasan->tanggal_selesai)));
        $indukbuku = IndukBuku::with(['pengarang', 'jualdetail'])->where('kode_buku', $request->kode_buku)->first();
        return $indukbuku;
    }

    public function api_royalti_user(Request $request){
        $pengarang = Pengarang::with(['kota', 'kecamatan', 'kelurahan', 'negara', 'indukbuku'])->where('nik', $request->nik)->first();
        $myArray = array();
        $sumharga = 0;
        $sumpajak = 0;
        $sumhargabersih = 0;
        $status_royalti = 0;
        if($pengarang->indukbuku != NULL){
            foreach($data->indukbuku as $data2){
                if(count($data2->jualdetail) > 0){
                    foreach($data2->jualdetail as $data3){
                        if($data3->returroyalti != NULL){
                            $hargatotal += $data3->total_non_diskon -  $data3->returroyalti->total_non_diskon;
                        }else{
                            $hargatotal += $data3->total_non_diskon;
                        }
                    }
                }
            }
            if($data->NPWP != ''){
                $sumhargabersih += (($hargatotal * $data->persen_royalti) / 100);
                $sumpajak += 0;
                $sumharga += (($hargatotal * $data->persen_royalti) / 100);
            }else{
                $sumharga += (($hargatotal * $data->persen_royalti) / 100);
                $sumhargabersih += (($hargatotal* $data->persen_royalti) / 100) - (((($hargatotal * $data->persen_royalti) / 100) * 15) / 100);
                $sumpajak += (((($hargatotal * $data->persen_royalti) / 100) * 15) / 100);
            }
        }
        $sumharga = round($sumharga);
        $status_royalti = (int) $status_royalti;
        $myArray[] = array('id' => $pengarang->id_pengarang,'nama' => $pengarang->nm_pengarang, 'telepon' => $pengarang->telepon, 'email' => $pengarang->email, 'alamat' => $pengarang->alamat . " Kel. " . ucwords(strtolower($pengarang->kelurahan->name)) . "," . " Kec. " . ucwords(strtolower($pengarang->kecamatan->name)) . ", " . ucwords(strtolower($pengarang->kota->name)) . " " . $pengarang->kode_pos, 'total_royalti' => $sumharga, 'pajak' => $sumpajak, 'total_royalti_bersih' => $sumhargabersih);
        return $myArray;
    }

    public function api_royalti_all(Request $request){
        $pengarang = Pengarang::with(['kota', 'kecamatan', 'kelurahan', 'negara', 'indukbuku'])->get();
        $myArray = array();
        foreach($pengarang as $data){
            $sumharga = 0;
            $sumpajak = 0;
            $sumhargabersih = 0;
            $status_royalti = 0;
            $hargatotal = 0;
            if($data->indukbuku != NULL){
                foreach($data->indukbuku as $data2){
                    if(count($data2->jualdetail) > 0){
                        foreach($data2->jualdetail as $data3){
                            if($data3->returroyalti != NULL){
                                $hargatotal += $data3->total_non_diskon -  $data3->returroyalti->total_non_diskon;
                            }else{
                                $hargatotal += $data3->total_non_diskon;
                            }
                        }
                    }
                }
                if($data->NPWP != ''){
                    $sumhargabersih += (($hargatotal * $data->persen_royalti) / 100);
                    $sumpajak += 0;
                    $sumharga += (($hargatotal * $data->persen_royalti) / 100);
                }else{
                    $sumharga += (($hargatotal * $data->persen_royalti) / 100);
                    $sumhargabersih += (($hargatotal* $data->persen_royalti) / 100) - (((($hargatotal * $data->persen_royalti) / 100) * 15) / 100);
                    $sumpajak += (((($hargatotal * $data->persen_royalti) / 100) * 15) / 100);
                }
                $sumhargabersih = round($sumhargabersih);
                $sumpajak = round($sumpajak);
                $sumharga = round($sumharga);
                $status_royalti = (int) $status_royalti;
                $myArray[] = array('id' => $data->id_pengarang,'nama' => $data->nm_pengarang, 'telepon' => $data->telepon, 'email' => $data->email, 'alamat' => $data->alamat . " Kel. " . ucwords(strtolower($data->kelurahan->name)) . "," . " Kec. " . ucwords(strtolower($data->kecamatan->name)) . ", " . ucwords(strtolower($data->kota->name)) . " " . $data->kode_pos, 'total_royalti' => $sumharga, 'pajak' => $sumpajak, 'total_royalti_bersih' => $sumhargabersih);
            }
        }
        return $myArray;
    }

    public function not_found(){
        return view('User.not_found');
    }
}
