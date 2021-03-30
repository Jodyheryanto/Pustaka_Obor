<?php

namespace App\Http\Controllers\Admin;

use Alert;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\BeliBuku;
use App\Models\ReturBeli;
use App\Models\FakturReturBeli;
use App\Models\Stok;
use App\Models\Histori;
use App\Models\JurnalUmum;

class AdminReturBeliController extends Controller
{
    function showCreateForm(){
        $belibuku = BeliBuku::with(['indukbuku'])->get();
        return view('Admin.ReturBeli.create', compact(['belibuku']));
    }

    public function create(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        $stok = Stok::find($request->kode_buku);
        $databeli = BeliBuku::where('id_pembelian_buku', $request->id_pembelian_buku)->first();
        if($stok->qty >= $request->qty_retur){
            $harga_total = 0;
            if($request->diskon_retur != 0){
                $harga_total = (($request->qty_retur*$databeli->harga_beli_satuan)*$request->diskon_retur)/100;
            }else{
                $harga_total = $request->qty_retur*$databeli->harga_beli_satuan;
            }
            ReturBeli::insert([
                'tb_pembelian_buku_id' => $request->id_pembelian_buku,
                'qty' => $request->qty_retur,
                'discount' => 0,
                'note' => $request->note_retur,
                'status_retur_pembelian' => 0,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $data = ReturBeli::select('id_retur_pembelian')->orderBy('id_retur_pembelian', 'desc')->first();
            $id_retur_pembelian = $data->id_retur_pembelian;
            $belibuku = BeliBuku::with(['supplier'])->where('id_pembelian_buku', $request->id_pembelian_buku)->first();
            Histori::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'id_transaksi' => 'RB' . $id_retur_pembelian,
                'entitas' => $belibuku->supplier->nm_supplier,
                'qty' => $request->qty_retur,
                'status' => 0,
                'discount' => 0,
                'harga_satuan' => $belibuku->harga_beli_satuan,
                'harga_total' => $harga_total,
                'stok_awal' => $stok->qty,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $returbeli = ReturBeli::with(['belibuku'])->get();
            $valid = 0;
            foreach($returbeli as $data){
            // var_dump($data->updated_at['date']);die;
                if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0 && $request->id_supplier == $data->belibuku->tb_supplier_id){
                    $faktur = FakturReturBeli::where('tb_retur_pembelian_id', $data->id_retur_pembelian)->first();
                    if($faktur !== NULL){
                        FakturReturBeli::insert([
                            'id_faktur_retur_pembelian' => $faktur->id_faktur_retur_pembelian,
                            'tb_retur_pembelian_id' => $id_retur_pembelian
                        ]);
                    }else{
                        $fakturterakhir = FakturReturBeli::select('id_faktur_retur_pembelian')->orderBy('id_faktur_retur_pembelian', 'desc')->first();
                        if($fakturterakhir === NULL){
                            FakturReturBeli::insert([
                                'id_faktur_retur_pembelian' => 'FKTRB1',
                                'tb_retur_pembelian_id' => $id_retur_pembelian
                            ]);
                        }else{
                            $id_faktur_retur_pembelian = $fakturterakhir->id_faktur_retur_pembelian;
                            $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_retur_pembelian);
                            $id_faktur_retur_pembelian = (int) $split[1] + 1;
                            $id_faktur_retur_pembelian = 'FKTRB' . $id_faktur_retur_pembelian;
                            FakturReturBeli::insert([
                                'id_faktur_retur_pembelian' => $id_faktur_retur_pembelian,
                                'tb_retur_pembelian_id' => $id_retur_pembelian
                            ]);
                        }
                    }
                    $valid = 1;
                }
            }
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            JurnalUmum::insert([
                'tb_retur_pembelian_id' => $id_retur_pembelian,
                'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                'debit_hutang' => $harga_total,
                'kredit_retur_pembelian' => $harga_total,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $stok->qty =  $stok->qty - $request->qty_retur;
            $stok->save();
            // alihkan halaman tambah buku ke halaman books
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->route('admin.inventori.retur-pembelian.list');
        }else{
            // alihkan halaman tambah buku ke halaman books
            Alert::error('Gagal', 'Kondisi Khusus. Error karena qty pada stok tidak cukup');
            return redirect()->route('admin.inventori.retur-pembelian.list');
        }
    }
    
    function showEditForm($id){
        $returbeli = ReturBeli::with(['belibuku'])->where('id_retur_pembelian', $id)->first();
        $belibuku = BeliBuku::with(['indukbuku'])->get();
        return view('Admin.ReturBeli.edit', compact(['returbeli', 'belibuku']));
    }

    public function update(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        $returbeli = ReturBeli::find($request->id_retur_pembelian);
        $tempqty = $returbeli->qty_retur;
        if($request->kode_buku == $request->kode_buku_sblm){
            $returbeli->tb_pembelian_buku_id =  $request->id_pembelian_buku;
            $returbeli->qty = $request->qty_retur;
            $returbeli->note = $request->note_retur;
            $returbeli->discount = $request->diskon_retur;
            $returbeli->status_retur_pembelian = $request->status_retur_pembelian;
            $returbeli->save();

            $stok = Stok::find($request->kode_buku);
            if($tempqty > $request->qty){
                $stok->qty =  $stok->qty + ($tempqty - $request->qty_retur);
            }else{
                $stok->qty =  $stok->qty - ($request->qty_retur - $tempqty);
            }
            $stok->save();
        }else{
            $stok = Stok::find($request->kode_buku_sblm);
            $stok->qty =  $stok->qty + $tempqty;

            $returbeli->tb_pembelian_buku_id =  $request->id_pembelian_buku;
            $returbeli->qty = $request->qty_retur;
            $returbeli->discount = $request->diskon_retur;
            $returbeli->note = $request->note_retur;
            $returbeli->status_retur_pembelian = $request->status_retur_pembelian;
            $returbeli->updated_at = $now->format('Y-m-d H:i:s');
            $returbeli->save();

            $stok = Stok::find($request->kode_buku);
            $stok->qty =  $stok->qty - $request->qty_retur;
            $stok->save();
        }

        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.inventori.retur-pembelian.list');
    }

    function delete(Request $request){
        $histori = Histori::where('id_transaksi','RB'.$request->id_retur_pembelian)->first();
        $histori->status =  1;
        $histori->save();
        $stok = Stok::find($request->kode_buku);
        $stok->qty =  $stok->qty + $request->qty_retur;
        $stok->save();
        $returbeli = ReturBeli::where('id_retur_pembelian',$request->id_retur_pembelian)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.inventori.retur-pembelian.list');
    }

    function list(){
        $fakturdb = FakturReturBeli::with(['returbeli'])->get();
        $myArray = array();
        $faktur = array();
        $i = -1;
        foreach($fakturdb as $data){
            $myArray[] = array('id_faktur' => $data->id_faktur_retur_pembelian, 'nama_supplier' => $data->returbeli->belibuku->supplier->nm_supplier, 'tgl_faktur' => $data->returbeli->updated_at);
        }
        usort($myArray, function($a, $b) {
            return $a['id_faktur'] <=> $b['id_faktur'];
        });
        foreach($myArray as $data){
            if($data !== NULL){
                if($i === -1){
                    $faktur[] = array('id_faktur' => $data['id_faktur'], 'nama_supplier' => $data['nama_supplier'], 'tgl_faktur' => $data['tgl_faktur']);
                    $i++;
                }
                if($faktur[$i]['id_faktur'] !== $data['id_faktur']){
                    $faktur[] = array('id_faktur' => $data['id_faktur'], 'nama_supplier' => $data['nama_supplier'], 'tgl_faktur' => $data['tgl_faktur']);
                    $i++;
                }
            }
        }
        $returbeli = ReturBeli::with(['belibuku'])->get();
        return view('Admin.ReturBeli.list', compact(['returbeli', 'faktur']));
    }

    function cetak(Request $request){
        $faktur = FakturReturBeli::with(['returbeli'])->where('id_faktur_retur_pembelian', $request->id_faktur)->get();
        $fakturone = FakturReturBeli::with(['returbeli'])->where('id_faktur_retur_pembelian', $request->id_faktur)->first();
        return view('Admin.ReturBeli.cetak', compact(['faktur', 'fakturone']));
    }
}
