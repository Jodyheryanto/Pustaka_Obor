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
use App\Models\Supplier;


class AdminSupplierController extends Controller
{
    function showCreateForm(){
        $cities = City::pluck('name', 'id');
        return view('Admin.Supplier.create', compact(['cities']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Supplier::insert([
            'nm_supplier' => $request->nm_supplier,
            'nm_perusahaan' => $request->nm_perusahaan,
            'telepon' => $request->telepon,
            'tb_kota_id' => $request->kota,
            'tb_kecamatan_id' => $request->kecamatan,
            'tb_kelurahan_id' => $request->kelurahan,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat
        ]);
        Alert::success('Success', 'Data berhasil disimpan');
        // alihkan halaman tambah buku ke halaman books
        return redirect()->route('admin.master.supplier.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $supplier = Supplier::where('id_supplier', $id)->first();
        $cities = City::pluck('name', 'id');
        $districts = District::where('city_id', $supplier->tb_kota_id)->pluck('name', 'id');
        $villages = Village::where('district_id', $supplier->tb_kecamatan_id)->pluck('name', 'id');
        return view('Admin.Supplier.edit', compact(['supplier', 'districts', 'villages', 'cities']));
    }

    public function update(Request $request)
	{
        $supplier = Supplier::find($request->id_supplier);
        
        $supplier->nm_supplier = $request->nm_supplier;
        $supplier->nm_perusahaan = $request->nm_perusahaan;
        $supplier->telepon = $request->telepon;
        $supplier->tb_kota_id = $request->kota;
        $supplier->tb_kelurahan_id = $request->kelurahan;
        $supplier->tb_kecamatan_id = $request->kecamatan;
        $supplier->kode_pos = $request->kode_pos;
        $supplier->alamat = $request->alamat;
        $supplier->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.supplier.list');
    }

    function delete(Request $request){
        $supplier = Supplier::where('id_supplier',$request->id_supplier)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.master.supplier.list');
    }

    function list(){
        $supplier = Supplier::with(['kota', 'kecamatan', 'kelurahan'])->get();
        return view('Admin.Supplier.list', compact(['supplier']));
    }

    public function getInfo($id)
    {
        $fill = Supplier::with(['kota', 'kecamatan', 'kelurahan'])->where('id_supplier', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
