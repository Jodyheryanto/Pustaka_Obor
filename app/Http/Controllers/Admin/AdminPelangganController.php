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
use App\Models\Pelanggan;


class AdminPelangganController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        return view('Admin.Pelanggan.create', compact(['cities']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Pelanggan::insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tb_kota_id' => $request->kota,
            'tb_kecamatan_id' => $request->kecamatan,
            'tb_kelurahan_id' => $request->kelurahan,
            'alamat' => $request->alamat,
            'discount' => $request->diskon,
            'tanggal_lahir' => $request->tanggal_lahir
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.master.pelanggan.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->first();
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $pelanggan->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $pelanggan->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Pelanggan.edit', compact(['pelanggan', 'districts', 'villages', 'cities']));
    }

    public function update(Request $request)
	{
        $pelanggan = Pelanggan::find($request->id_pelanggan);
        
        $pelanggan->nama = $request->nama;
        $pelanggan->email = $request->email;
        $pelanggan->telepon = $request->telepon;
        $pelanggan->tb_kota_id = $request->kota;
        $pelanggan->tb_kelurahan_id = $request->kelurahan;
        $pelanggan->tb_kecamatan_id = $request->kecamatan;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->tanggal_lahir = $request->tanggal_lahir;
        $pelanggan->discount = $request->diskon;
        $pelanggan->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.pelanggan.list');
    }

    function delete(Request $request){
        $pelanggan = Pelanggan::where('id_pelanggan',$request->id_pelanggan)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.master.pelanggan.list');
    }

    function list(){
        $pelanggan = Pelanggan::with(['kota', 'kecamatan', 'kelurahan'])->get();
        return view('Admin.Pelanggan.list', compact(['pelanggan']));
    }

    public function getInfo($id)
    {
        $fill = Pelanggan::with(['kota', 'kecamatan', 'kelurahan'])->where('id_pelanggan', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
