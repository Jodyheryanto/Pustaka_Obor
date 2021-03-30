<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Country;
use DB;
use App\Models\Pengarang;
use App\Models\JualBuku;
use App\Models\BatasanWaktu;

class AdminPengarangController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        return view('Admin.Pengarang.create', compact(['cities', 'countries']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Pengarang::insert([
            'NPWP' => $request->NPWP,
            'NIK' => $request->NIK,
            'nm_pengarang' => $request->nm_pengarang,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tb_negara_id' => $request->negara,
            'tb_kota_id' => $request->kota,
            'tb_kecamatan_id' => $request->kecamatan,
            'tb_kelurahan_id' => $request->kelurahan,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
            'persen_royalti' => $request->persen_royalti,
            'nama_rekening' => $request->nama_rek,
            'bank_rekening' => $request->bank_rek,
            'nomor_rekening' => $request->no_rek,
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.master.pengarang.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $pengarang = Pengarang::where('id_pengarang', $id)->first();
        $countries = Country::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $pengarang->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $pengarang->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Pengarang.edit', compact(['pengarang', 'countries', 'cities', 'districts', 'villages']));
    }

    public function update(Request $request)
	{
        $pengarang = Pengarang::find($request->id_pengarang);
        
        $pengarang->nm_pengarang = $request->nm_pengarang;
        $pengarang->email = $request->email;
        $pengarang->telepon = $request->telepon;
        $pengarang->tb_kota_id = $request->kota;
        $pengarang->tb_negara_id = $request->negara;
        $pengarang->tb_kelurahan_id = $request->kelurahan;
        $pengarang->tb_kecamatan_id = $request->kecamatan;
        $pengarang->kode_pos = $request->kode_pos;
        $pengarang->NPWP = $request->NPWP;
        $pengarang->NIK = $request->NIK;
        $pengarang->persen_royalti = $request->persen_royalti;
        $pengarang->nama_rekening = $request->nama_rek;
        $pengarang->bank_rekening = $request->bank_rek;
        $pengarang->nomor_rekening = $request->no_rek;
        $pengarang->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.pengarang.list');
    }

    function delete(Request $request){
        $pengarang = Pengarang::where('id_pengarang',$request->id_pengarang)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        
        return redirect()->route('admin.master.pengarang.list');
    }

    function list(Request $request){
        // $batasan = BatasanWaktu::where('id', 1)->first();
        // $request->session()->put('tgl_mulai', date('Y-m-d', strtotime($batasan->tanggal_mulai)));
        // $request->session()->put('tgl_selesai', date('Y-m-d', strtotime($batasan->tanggal_selesai)));
        $pengarang = Pengarang::with(['kota', 'kecamatan', 'kelurahan', 'negara', 'indukbuku'])->get();
        return view('Admin.Pengarang.list', compact(['pengarang']));
    }

    public function getInfo($id)
    {
        $fill = Pengarang::with(['kota', 'kecamatan', 'kelurahan', 'negara'])->where('id_pengarang', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }

    public function ubahStatus(Request $request){
        $jualbuku = JualBuku::join('tb_induk_buku','tb_penjualan_buku.tb_induk_buku_kode_buku','=','tb_induk_buku.kode_buku')
            ->where('tb_induk_buku.tb_pengarang_id', $request->id_pengarang)->where('tb_penjualan_buku.status_royalti', 0)
            ->update(['tb_penjualan_buku.status_royalti' => 1]);

        Alert::success('Success', 'Royalti penulis telah dilakukan pembayaran');
        return redirect()->route('admin.master.pengarang.list');
    }
}
