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
use App\Models\Penerjemah;

class AdminPenerjemahController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        return view('Admin.Penerjemah.create', compact(['cities']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Penerjemah::insert([
            'NPWP' => $request->NPWP,
            'nm_penerjemah' => $request->nm_penerjemah,
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
        return redirect()->route('admin.master.penerjemah.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $penerjemah = Penerjemah::where('id_penerjemah', $id)->first();
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $penerjemah->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $penerjemah->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Penerjemah.edit', compact(['penerjemah', 'cities', 'districts', 'villages']));
    }

    public function update(Request $request)
	{
        $penerjemah = Penerjemah::find($request->id_penerjemah);
        
        $penerjemah->nm_penerjemah = $request->nm_penerjemah;
        $penerjemah->email = $request->email;
        $penerjemah->telepon = $request->telepon;
        $penerjemah->tb_kota_id = $request->kota;
        $penerjemah->tb_kelurahan_id = $request->kelurahan;
        $penerjemah->tb_kecamatan_id = $request->kecamatan;
        $penerjemah->kode_pos = $request->kode_pos;
        $penerjemah->NPWP = $request->NPWP;
        $penerjemah->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.penerjemah.list');
    }

    function delete(Request $request){
        $penerjemah = Penerjemah::where('id_penerjemah',$request->id_penerjemah)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        
        return redirect()->route('admin.master.penerjemah.list');
    }

    function list(){
        $penerjemah = Penerjemah::with(['kota', 'kecamatan', 'kelurahan'])->get();
        return view('Admin.Penerjemah.list', compact(['penerjemah']));
    }

    public function getInfo($id)
    {
        $fill = Penerjemah::with(['kota', 'kecamatan', 'kelurahan'])->where('id_penerjemah', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
