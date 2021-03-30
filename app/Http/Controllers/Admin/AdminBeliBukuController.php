<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DateTime;
use DB;
use App\Models\City;
use App\Models\BeliBuku;
use App\Models\IndukBuku;
use App\Models\Supplier;
use App\Models\Stok;
use App\Models\Histori;
use App\Models\FakturBeli;
use App\Models\KasKeluar;
use App\Models\JurnalBeli;

class AdminBeliBukuController extends Controller
{
    function showCreateForm(){
        $indukbuku = IndukBuku::all();
        $supplier = Supplier::all();
        $cities = City::pluck('name', 'id');
        return view('Admin.BeliBuku.create', compact(['indukbuku', 'supplier', 'cities']));
    }

    public function create(Request $request)
	{
        $id_supplier = $request->id_supplier;
        // insert data ke table books
        if($request->id_supplier === NULL){
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
            $data = Supplier::select('id_supplier')->orderBy('id_supplier', 'desc')->first();
            $id_supplier = $data->id_supplier;
        }
        // insert data ke table books
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        BeliBuku::insert([
            'tb_induk_buku_kode_buku' => $request->kode_buku,
            'tb_supplier_id' => $id_supplier,
            'qty' => $request->qty,
            'harga_beli_satuan' => $request->harga_beli_satuan,
            'total_harga' => $request->qty*$request->harga_beli_satuan,
            'note' => $request->note,
            'tgl_ppn' => $now->format('Y-m-d'),
            'status_pembelian' => $request->status_pembelian,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s')
        ]);
        $data = BeliBuku::select('id_pembelian_buku')->orderBy('id_pembelian_buku', 'desc')->first();
        $id_pembelian = $data->id_pembelian_buku;
        $stok = Stok::find($request->kode_buku);
        $supplier = Supplier::where('id_supplier', $id_supplier)->first();
        Histori::insert([
            'tb_induk_buku_kode_buku' => $request->kode_buku,
            'id_transaksi' => 'B' . $id_pembelian,
            'entitas' => $supplier->nm_supplier,
            'qty' => $request->qty,
            'status' => 0,
            'discount' => 0,
            'harga_satuan' => $request->harga_beli_satuan,
            'harga_total' => $request->qty*$request->harga_beli_satuan,
            'stok_awal' => $stok->qty,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s')
        ]);
        $stok->qty =  $stok->qty + $request->qty;
        $stok->save();
        if($request->status_pembelian == 0){
            $databeli = BeliBuku::select('tb_pembelian_buku.id_pembelian_buku as id_pembelian_buku', 'tb_pembelian_buku.updated_at as updated_at')->where('tb_pembelian_buku.tb_supplier_id', $id_supplier)
                        ->join('tb_faktur_pembelian','tb_faktur_pembelian.tb_pembelian_buku_id','=','tb_pembelian_buku.id_pembelian_buku')
                        ->where('tb_faktur_pembelian.id_faktur_pembelian', 'like', '%FKTBBT%')
                        ->where('tb_pembelian_buku.updated_at', 'like', date('Y-m-d').'%')
                        ->orderBy('tb_pembelian_buku.updated_at', 'desc')
                        ->first();
            if($databeli != NULL){
                $faktur = Fakturbeli::where('tb_pembelian_buku_id', $databeli->id_pembelian_buku)->first();
                Fakturbeli::insert([
                    'id_faktur_pembelian' => $faktur->id_faktur_pembelian,
                    'tb_pembelian_buku_id' => $id_pembelian,
                    'status_bayar' => 1
                ]);
            }else{
                $fakturterakhir = Fakturbeli::select('id_faktur_pembelian')->orderBy('id_faktur_pembelian', 'desc')->where('id_faktur_pembelian', 'like', '%FKTBBT%')->first();
                if($fakturterakhir === NULL){
                    Fakturbeli::insert([
                        'id_faktur_pembelian' => 'FKTBBT1',
                        'tb_pembelian_buku_id' => $id_pembelian,
                        'status_bayar' => 1
                    ]);
                }else{
                    $id_faktur_pembelian = $fakturterakhir->id_faktur_pembelian;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_pembelian);
                    $id_faktur_pembelian = (int) $split[1] + 1;
                    $id_faktur_pembelian = 'FKTBBT' . $id_faktur_pembelian;
                    Fakturbeli::insert([
                        'id_faktur_pembelian' => $id_faktur_pembelian,
                        'tb_pembelian_buku_id' => $id_pembelian,
                        'status_bayar' => 1
                    ]);
                }
            }
            $faktur = FakturBeli::select('id')->orderBy('id', 'desc')->where('id_faktur_pembelian', 'like', '%FKTBBT%')->first();
            $id_faktur = $faktur->id;
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            KasKeluar::insert([
                'tb_terima_bukti_id' => $id_faktur,
                'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                'note' => "tunai",
                'debit_pembelian' => $request->qty*$request->harga_beli_satuan,
                'kredit_kas_keluar' => $request->qty*$request->harga_beli_satuan,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
        }else{
            $databeli = BeliBuku::select('tb_pembelian_buku.id_pembelian_buku as id_pembelian_buku', 'tb_pembelian_buku.updated_at as updated_at')->where('tb_pembelian_buku.tb_supplier_id', $id_supplier)
                        ->join('tb_faktur_pembelian','tb_faktur_pembelian.tb_pembelian_buku_id','=','tb_pembelian_buku.id_pembelian_buku')
                        ->where('tb_faktur_pembelian.id_faktur_pembelian', 'like', '%FKTBBN%')
                        ->where('tb_pembelian_buku.updated_at', 'like', date('Y-m-d').'%')
                        ->orderBy('tb_pembelian_buku.updated_at', 'desc')
                        ->first();
            if($databeli != NULL){
                $faktur = Fakturbeli::where('tb_pembelian_buku_id', $databeli->id_pembelian_buku)->first();
                Fakturbeli::insert([
                    'id_faktur_pembelian' => $faktur->id_faktur_pembelian,
                    'tb_pembelian_buku_id' => $id_pembelian,
                    'status_bayar' => 0
                ]);
            }else{
                $fakturterakhir = Fakturbeli::select('id_faktur_pembelian')->orderBy('id_faktur_pembelian', 'desc')->where('tb_faktur_pembelian.id_faktur_pembelian', 'like', '%FKTBBN%')->first();
                if($fakturterakhir == NULL){
                    Fakturbeli::insert([
                        'id_faktur_pembelian' => 'FKTBBN1',
                        'tb_pembelian_buku_id' => $id_pembelian,
                        'status_bayar' => 0
                    ]);
                }else{
                    $id_faktur_pembelian = $fakturterakhir->id_faktur_pembelian;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_pembelian);
                    $id_faktur_pembelian = (int) $split[1] + 1;
                    $id_faktur_pembelian = 'FKTBBN' . $id_faktur_pembelian;
                    Fakturbeli::insert([
                        'id_faktur_pembelian' => $id_faktur_pembelian,
                        'tb_pembelian_buku_id' => $id_pembelian,
                        'status_bayar' => 0
                    ]);
                }
            }
            $faktur = FakturBeli::select('id')->orderBy('id', 'desc')->where('id_faktur_pembelian', 'like', '%FKTBBN%')->first();
            $id_faktur = $faktur->id;
            $supplier = Supplier::where('id_supplier', $id_supplier)->first();
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            JurnalBeli::insert([
                'tb_terima_bukti_id' => $id_faktur,
                'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                'supplier' => $supplier->nm_supplier,
                'note' => "ini non tunai",
                'syarat_pembayaran' => "ini non tunai",
                'debit_pembelian' => $request->qty*$request->harga_beli_satuan,
                'kredit_hutang' => $request->qty*$request->harga_beli_satuan,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
        }
        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.inventori.pembelian-buku.list');
        // ->with('success', 'Course successfully created!');
    }
    
    function showEditForm($id){
        $indukbuku = IndukBuku::all();
        $supplier = Supplier::all();
        $belibuku = BeliBuku::where('id_pembelian_buku', $id)->first();
        return view('Admin.BeliBuku.edit', compact(['indukbuku', 'supplier', 'belibuku']));
    }

    public function update(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        $belibuku = BeliBuku::find($request->id_pembelian_buku);
        $tempqty = $belibuku->qty;
        if($belibuku->tb_induk_buku_kode_buku == $request->kode_buku){
            $belibuku->tb_supplier_id = $request->id_supplier;
            $belibuku->qty = $request->qty;
            $belibuku->harga_beli_satuan = $request->harga_beli_satuan;
            $belibuku->total_harga = $request->qty*$request->harga_beli_satuan;
            $belibuku->note = $request->note;
            $belibuku->updated_at = $now->format('Y-m-d H:i:s');
            $belibuku->save();

            $stok = Stok::find($request->kode_buku);
            if($tempqty > $request->qty){
                $stok->qty =  $stok->qty - ($tempqty - $request->qty);
            }else{
                $stok->qty =  $stok->qty + ($request->qty - $tempqty);
            }
            $stok->save();
        }else{
            $stok = Stok::find($belibuku->tb_induk_buku_kode_buku);
            $stok->qty = $stok->qty - $tempqty;

            $belibuku->tb_induk_buku_kode_buku = $request->kode_buku;
            $belibuku->tb_supplier_id = $request->id_supplier;
            $belibuku->qty = $request->qty;
            $belibuku->harga_beli_satuan = $request->harga_beli_satuan;
            $belibuku->total_harga = $request->qty*$request->harga_beli_satuan;
            $belibuku->note = $request->note;
            $belibuku->save();

            $stok = Stok::find($request->kode_buku);
            $stok->qty =  $stok->qty + $request->qty;
            $stok->save();
        }
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.inventori.pembelian-buku.list');
    }

    function delete(Request $request){
        $returbeli = 0;
        $belibuku = BeliBuku::with('returdetail')->where('id_pembelian_buku',$request->id_pembelian_buku)->first();
        $stok = Stok::find($request->kode_buku);
        if(count($belibuku->returdetail) > 0){
            foreach($belibuku->returdetail as $data){
                $returbeli += $data->qty;
                $histori = Histori::where('id_transaksi','RB'.$data->id_retur_pembelian)->first();
                $histori->status =  1;
                $histori->save();
            }
        }
        $histori = Histori::where('id_transaksi','B'.$request->id_pembelian_buku)->first();
        $histori->status =  1;
        $histori->save();
        $stok->qty =  $stok->qty - ($request->qty_beli - $returbeli);
        $stok->save();
        $belibuku = BeliBuku::where('id_pembelian_buku',$request->id_pembelian_buku)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.inventori.pembelian-buku.list');
    }

    function list(){
        $fakturdb = FakturBeli::with(['belibuku'])->get();
        $myArray = array();
        $faktur = array();
        $i = -1;
        foreach($fakturdb as $data){
            $myArray[] = array('id_faktur' => $data->id_faktur_pembelian, 'nama_supplier' => $data->belibuku->supplier->nm_supplier, 'tgl_faktur' => $data->belibuku->updated_at);
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
        $belibuku = BeliBuku::with(['indukbuku', 'supplier'])->get();
        return view('Admin.BeliBuku.list', compact(['belibuku', 'faktur']));
    }

    public function getInfo($id)
    {
        $fill = BeliBuku::with(['indukbuku', 'supplier', 'returdetail'])->where('id_pembelian_buku', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }

    function cetak(Request $request){
        $faktur = FakturBeli::with(['belibuku'])->where('id_faktur_pembelian', $request->id_faktur)->get();
        $fakturCount = count($faktur);
        $dataLunas = FakturBeli::with(['belibuku'])->where('id_faktur_pembelian', $request->id_faktur)->where('status_bayar', 1)->count();
        $fakturone = FakturBeli::with(['belibuku'])->where('id_faktur_pembelian', $request->id_faktur)->first();
        return view('Admin.BeliBuku.cetak', compact(['faktur', 'fakturone', 'dataLunas', 'fakturCount']));
    }

    public function filter(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        $kode = $request->kode_analisa;
        if($request->kode_analisa == 0){
            $indukbuku = IndukBuku::with(['beliqtyhigh'])->get();
            $arrBuku = array();
            foreach($indukbuku as $data){
                if($data->beliqtyhigh != NULL){
                    $arrBuku[] = array('kode_buku' => $data->kode_buku, 'judul_buku' => $data->judul_buku, 'qtybeli' => $data->beliqtyhigh->qtybeli);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['qtybeli'] <=> $a['qtybeli'];
            });
            return view('Admin.BeliBuku.analisa', compact(['kode', 'arrBuku']));
        }elseif($request->kode_analisa == 1){
            $indukbuku = IndukBuku::with(['belinilaihigh'])->get();
            foreach($indukbuku as $data){
                if($data->belinilaihigh != NULL){
                    $arrBuku[] = array('kode_buku' => $data->kode_buku, 'judul_buku' => $data->judul_buku, 'nilaibeli' => $data->belinilaihigh->nilaibeli);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['nilaibeli'] <=> $a['nilaibeli'];
            });
            return view('Admin.BeliBuku.analisa', compact(['kode', 'arrBuku']));
        }elseif($request->kode_analisa == 2){
            $indukbuku = Supplier::with(['belibuku'])->get();
            foreach($indukbuku as $data){
                if($data->belibuku != NULL){
                    $arrBuku[] = array('id_supplier' => $data->id_supplier, 'nm_supplier' => $data->nm_supplier, 'qtybeli' => $data->belibuku->qtybeli, 'nilaibeli' => $data->belibuku->harga_total);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['nilaibeli'] <=> $a['nilaibeli'];
            });
            return view('Admin.BeliBuku.analisa', compact(['kode', 'arrBuku']));
        }
    }
}
