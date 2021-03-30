<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use App\Models\DataAccount;

class AdminDataAccountController extends Controller
{
    function showCreateForm(){
        return view('Admin.DataAccount.create');
    }

    public function create(Request $request)
	{
        // insert data ke table books
        $dataaccount = DataAccount::where('id_account', $request->id_account)->count();
        
        if($dataaccount > 0){
            $id_account = $request->id_account . '1';
        }else{
            $id_account = $request->id_account;
        }

        DataAccount::insert([
            'id_account' => $id_account,
            'nama_account' => $request->nama_account,
            'aliran_kas' => $request->aliran_kas,
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.buku-besar.data-account.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $dataaccount = DataAccount::where('id_account', $id)->first();
        return view('Admin.DataAccount.edit', compact(['dataaccount']));
    }

    public function update(Request $request)
	{
        $dataaccount = DataAccount::find($request->id_account);
        
        $dataaccount->nama_account = $request->nama_account;
        $dataaccount->aliran_kas = $request->aliran_kas;
        $dataaccount->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.buku-besar.data-account.list');
    }

    function delete(Request $request){
        $dataaccount = DataAccount::where('id_account',$request->id_account)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        
        return redirect()->route('admin.buku-besar.data-account.list');
    }

    function list(Request $request){
        $dataaccount = DataAccount::all();
        return view('Admin.DataAccount.list', compact(['dataaccount']));
    }
}
