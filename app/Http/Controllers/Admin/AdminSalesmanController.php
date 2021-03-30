<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\Salesman;

class AdminSalesmanController extends Controller
{
    function showCreateForm(){
        return view('Admin.Salesman.create');
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Salesman::insert([
            'nama' => $request->nama
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.master.salesman.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $salesman = Salesman::where('id_salesman', $id)->first();
        return view('Admin.Salesman.edit', compact(['salesman']));
    }

    public function update(Request $request)
	{
        $salesman = Salesman::find($request->id_salesman);
        
        $salesman->nama = $request->nama;
        $salesman->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.salesman.list');
    }

    function delete(Request $request){
        $salesman = Salesman::where('id_salesman',$request->id_salesman)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.master.salesman.list');
    }

    function list(){
        $salesman = Salesman::all();
        return view('Admin.Salesman.list', compact(['salesman']));
    }

    public function getInfo($id)
    {
        $fill = Salesman::where('id_salesman', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
