<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\Kategori;

class AdminKategoriController extends Controller
{
    function showCreateForm(){
        return view('Admin.Kategori.create');
    }

    public function create(Request $request)
	{
        // insert data ke table books
        Kategori::insert([
            'nama' => $request->nama
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.master.kategori.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $kategori = Kategori::where('id_kategori', $id)->first();
        return view('Admin.Kategori.edit', compact(['kategori']));
    }

    public function update(Request $request)
	{
        $kategori = Kategori::find($request->id_kategori);
        
        $kategori->nama = $request->nama;
        $kategori->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.master.kategori.list');
    }

    function delete(Request $request){
        $kategori = Kategori::where('id_kategori',$request->id_kategori)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.master.kategori.list');
    }

    function list(){
        $kategori = Kategori::all();
        return view('Admin.Kategori.list', compact(['kategori']));
    }
}
