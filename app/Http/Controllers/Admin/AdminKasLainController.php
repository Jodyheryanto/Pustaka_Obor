<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DateTime;
use App\Models\KasLain2;
use App\Models\DataAccount;

class AdminKasLainController extends Controller
{
    function showCreateForm(){
        $dataaccount = DataAccount::all();
        return view('Admin.KasLain.create', compact(['dataaccount']));
    }

    public function create(Request $request)
	{
        // insert data ke table books
        KasLain2::insert([
            'tb_data_account_id' => $request->id_account,
            'tgl_transaksi' => $request->tgl_transaksi,
            'debit' => $request->debit,
            'kredit' => $request->kredit,
            'note' => $request->note
        ]);
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        $request->session()->put('id_account', $request->id_account);
        $request->session()->put('tgl_mulai', date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ));
        $request->session()->put('tgl_selesai', date('Y-m-d'));
        return redirect()->route('admin.buku-besar.kas-lain2.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $datakas = KasLain2::where('id', $id)->first();
        $dataaccount = DataAccount::all();
        return view('Admin.KasLain.edit', compact(['datakas', 'dataaccount']));
    }

    public function update(Request $request)
	{
        $datakas = KasLain2::find($request->id);
        
        $datakas->tb_data_account_id = $request->id_account;
        $datakas->tgl_transaksi = $request->tgl_transaksi;
        $datakas->debit = $request->debit;
        $datakas->kredit = $request->kredit;
        $datakas->note = $request->note;
        $datakas->save();

        Alert::success('Success', 'Data berhasil diubah');
        $request->session()->put('id_account', $request->id_account);
        $request->session()->put('tgl_mulai', date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '-1 month' ) ));
        $request->session()->put('tgl_selesai', date('Y-m-d'));
        return redirect()->route('admin.buku-besar.kas-lain2.list');
    }

    function delete(Request $request){
        $datakas = KasLain2::where('id',$request->id)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        
        return redirect()->getUrlGenerator()->previous();
    }

    function list(Request $request){
        $id_account = NULL;
        if($request->id_account == NULL){
            $id_account = $request->session()->get('id_account');
            $tgl_mulai = $request->session()->get('tgl_mulai');
            $tgl_selesai = $request->session()->get('tgl_selesai');
        }else{
            $id_account = $request->id_account;
            $tgl_mulai = $request->tgl_mulai;
            $tgl_selesai = $request->tgl_selesai;
        }
        $kaslain = KasLain2::where('tb_data_account_id', $id_account)->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $tgl_mulai)))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $tgl_selesai)))->get();
        $dataaccount = DataAccount::where('id_account', $id_account)->first();
        return view('Admin.KasLain.list', compact(['dataaccount', 'kaslain']));
    }
}
