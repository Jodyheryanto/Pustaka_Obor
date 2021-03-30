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
use App\Models\Distributor;

class AdminDistributorController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        return view('Admin.Distributor.create', compact(['cities']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Distributor::insert([
            'NPWP' => $request->NPWP,
            'nm_distributor' => $request->nm_distributor,
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
        return redirect()->route('admin.master.distributor.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $distributor = Distributor::where('id_distributor', $id)->first();
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $distributor->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $distributor->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Distributor.edit', compact(['distributor', 'districts', 'villages', 'cities']));
    }

    public function update(Request $request)
	{
        $distributor = Distributor::find($request->id_distributor);
        
        $distributor->nm_distributor = $request->nm_distributor;
        $distributor->email = $request->email;
        $distributor->telepon = $request->telepon;
        $distributor->tb_kota_id = $request->kota;
        $distributor->tb_kelurahan_id = $request->kelurahan;
        $distributor->tb_kecamatan_id = $request->kecamatan;
        $distributor->kode_pos = $request->kode_pos;
        $distributor->NPWP = $request->NPWP;
        $distributor->alamat = $request->alamat;
        $distributor->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.distributor.list');
    }

    function delete(Request $request){
        $distributor = Distributor::where('id_distributor',$request->id_distributor)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.master.distributor.list');
    }

    function list(){
        $distributor = Distributor::with(['kota', 'kecamatan', 'kelurahan'])->get();
        return view('Admin.Distributor.list', compact(['distributor']));
    }

    public function getInfo($id)
    {
        $fill = Distributor::with(['kota', 'kecamatan', 'kelurahan'])->where('id_distributor', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
