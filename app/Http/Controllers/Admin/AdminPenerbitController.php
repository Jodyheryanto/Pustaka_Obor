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
use App\Models\Penerbit;

class AdminPenerbitController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        return view('Admin.Penerbit.create', compact(['cities']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Penerbit::insert([
            'NPWP' => $request->NPWP,
            'nm_penerbit' => $request->nm_penerbit,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tb_kota_id' => $request->kota,
            'tb_kecamatan_id' => $request->kecamatan,
            'tb_kelurahan_id' => $request->kelurahan,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.master.penerbit.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $penerbit = Penerbit::where('id_penerbit', $id)->first();
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $penerbit->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $penerbit->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Penerbit.edit', compact(['penerbit', 'cities', 'districts', 'villages']));
    }

    public function update(Request $request)
	{
        $penerbit = Penerbit::find($request->id_penerbit);
        
        $penerbit->nm_penerbit = $request->nm_penerbit;
        $penerbit->email = $request->email;
        $penerbit->telepon = $request->telepon;
        $penerbit->tb_kota_id = $request->kota;
        $penerbit->tb_kelurahan_id = $request->kelurahan;
        $penerbit->tb_kecamatan_id = $request->kecamatan;
        $penerbit->kode_pos = $request->kode_pos;
        $penerbit->NPWP = $request->NPWP;
        $penerbit->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.penerbit.list');
    }

    function delete(Request $request){
        $penerbit = Penerbit::where('id_penerbit',$request->id_penerbit)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        
        return redirect()->route('admin.master.penerbit.list');
    }

    function list(){
        $penerbit = Penerbit::with(['kota', 'kecamatan', 'kelurahan'])->get();
        return view('Admin.Penerbit.list', compact(['penerbit']));
    }

    public function getInfo($id)
    {
        $fill = Penerbit::with(['kota', 'kecamatan', 'kelurahan'])->where('id_penerbit', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
