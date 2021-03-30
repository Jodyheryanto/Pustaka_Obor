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
use DB;
use App\Models\Lokasi;

class AdminLokasiController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        return view('Admin.Lokasi.create', compact(['cities']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Lokasi::insert([
            'nm_lokasi' => $request->nm_lokasi,
            'tb_kota_id' => $request->kota,
            'tb_kecamatan_id' => $request->kecamatan,
            'tb_kelurahan_id' => $request->kelurahan,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.master.lokasi.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $lokasi = Lokasi::where('id_lokasi', $id)->first();
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $lokasi->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $lokasi->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Lokasi.edit', compact(['lokasi', 'cities', 'districts', 'villages']));
    }

    public function update(Request $request)
	{
        $lokasi = Lokasi::find($request->id_lokasi);
        
        $lokasi->nm_lokasi = $request->nm_lokasi;
        $lokasi->tb_kota_id = $request->kota;
        $lokasi->tb_kelurahan_id = $request->kelurahan;
        $lokasi->tb_kecamatan_id = $request->kecamatan;
        $lokasi->kode_pos = $request->kode_pos;
        $lokasi->alamat = $request->alamat;
        $lokasi->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.lokasi.list');
    }

    function delete(Request $request){
        $lokasi = Lokasi::where('id_lokasi',$request->id_lokasi)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.master.lokasi.list');
    }

    function list(){
        $lokasi = Lokasi::with(['kota', 'kecamatan', 'kelurahan'])->get();
        return view('Admin.Lokasi.list', compact(['lokasi']));
    }
}
