<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;
use App\Models\IndukBuku;
use App\Models\FakturKonsinyasi;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Stok;
use App\Models\Pelanggan;
use App\Models\JualBuku;
use App\Models\Histori;
use App\Models\FakturJual;
use App\Models\FakturBeli;
use App\Models\BeliBuku;
use App\Models\Supplier;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\JurnalUmum;

class AdminKonsinyasiController extends Controller
{
    function showCreateForm(Request $request){
        if($request->status_titip == 0){
            $indukbuku = IndukBuku::with(['konsinyasi', 'distributor', 'stock'])->get();
            $cities = City::pluck('name', 'id');
            $pelanggan = Pelanggan::all();
            $max = IndukBuku::with(['stock'])->join('tb_stock','tb_stock.tb_induk_buku_kode_buku','=','tb_induk_buku.kode_buku')
            ->where('tb_stock.qty', '>', 0)->orderBy('kode_buku', 'ASC')
            ->first();
            if($max === NULL){
                $max = 0;
            }else{
                $max = $max->stock->qty;
            }
            $myArray = array();
            $faktur = array();
            $i = -1;
            $j = 0;
            $buku1 = IndukBuku::select('tb_induk_buku.harga_jual', 'tb_induk_buku.is_obral')
            ->join('tb_stock','tb_stock.tb_induk_buku_kode_buku','=','tb_induk_buku.kode_buku')
            ->where('tb_stock.qty', '>', 0)->orderBy('kode_buku', 'ASC')
            ->first();
            foreach($indukbuku as $buku){
                if($buku->konsinyasi !== NULL){
                    foreach($buku->konsinyasi as $data2){
                        $myArray[] = array('nm_distributor' => $buku->distributor->nm_distributor, 'id_faktur' => $data2->id_faktur_konsinyasi, 'tgl_faktur' => $data2->updated_at);
                    }
                }else{
                    if($j === 0 || $buku->stock !== NULL){
                        $max = $buku->stock->qty;
                        $j = 1;
                    }
                }
            }
            usort($myArray, function($a, $b) {
                return $a['id_faktur'] <=> $b['id_faktur'];
            });
            foreach($myArray as $data){
                if($data !== NULL){
                    if($i === -1){
                        $faktur[] = array('nm_distributor' => $data['nm_distributor'], 'id_faktur' => $data['id_faktur'], 'tgl_faktur' => $data['tgl_faktur']);
                        $i++;
                    }
                    if($faktur[$i]['id_faktur'] !== $data['id_faktur']){
                        $faktur[] = array('nm_distributor' => $data['nm_distributor'], 'id_faktur' => $data['id_faktur'], 'tgl_faktur' => $data['tgl_faktur']);
                        $i++;
                    }
                }
            }
            return view('Admin.Konsinyasi.createtitip', compact(['max', 'indukbuku', 'faktur', 'cities', 'pelanggan', 'buku1']));
        }else{
            $indukbuku = IndukBuku::with(['konsinyasi', 'distributor', 'stock'])->get();
            $cities = City::pluck('name', 'id');
            $supplier = Supplier::all();
            $myArray = array();
            $faktur = array();
            $i = -1;
            $j = 0;
            foreach($indukbuku as $buku){
                if($buku->konsinyasi !== NULL){
                    foreach($buku->konsinyasi as $data2){
                        $myArray[] = array('nm_distributor' => $buku->distributor->nm_distributor, 'id_faktur' => $data2->id_faktur_konsinyasi, 'tgl_faktur' => $data2->updated_at);
                    }
                }
            }
            usort($myArray, function($a, $b) {
                return $a['id_faktur'] <=> $b['id_faktur'];
            });
            foreach($myArray as $data){
                if($data !== NULL){
                    if($i === -1){
                        $faktur[] = array('nm_distributor' => $data['nm_distributor'], 'id_faktur' => $data['id_faktur'], 'tgl_faktur' => $data['tgl_faktur']);
                        $i++;
                    }
                    if($faktur[$i]['id_faktur'] !== $data['id_faktur']){
                        $faktur[] = array('nm_distributor' => $data['nm_distributor'], 'id_faktur' => $data['id_faktur'], 'tgl_faktur' => $data['tgl_faktur']);
                        $i++;
                    }
                }
            }
            return view('Admin.Konsinyasi.createterima', compact(['indukbuku', 'faktur', 'cities', 'supplier']));
        }
    }

    public function create(Request $request)
	{
        if($request->status_titip == 0){
            $id_pelanggan = $request->id_pelanggan;
            // insert data ke table books
            if($request->id_pelanggan === NULL){
                Pelanggan::insert([
                    'nama' => $request->nm_pelanggan,
                    'email' => $request->email_pelanggan,
                    'telepon' => $request->telepon_pelanggan,
                    'tb_kota_id' => $request->kota_pelanggan,
                    'tb_kecamatan_id' => $request->kecamatan_pelanggan,
                    'tb_kelurahan_id' => $request->kelurahan_pelanggan,
                    'alamat' => $request->alamat_pelanggan,
                    'tanggal_lahir' => $request->tanggal_lahir
                ]);
                $data = Pelanggan::select('id_pelanggan')->orderBy('id_pelanggan', 'desc')->first();
                $id_pelanggan = $data->id_pelanggan;
            }
            if($request->diskon !== NULL){
                $harga_diskon = ($request->diskon * ($request->qty*$request->harga_satuan)) / 100;
                $harga_total = ($request->qty*$request->harga_satuan) - $harga_diskon;
                $diskon = $request->diskon;
            }else{
                $harga_total = $request->qty*$request->harga_satuan;
                $diskon = 0;
            }
            date_default_timezone_set("Asia/Bangkok");
            $now = new DateTime();
            $indukbuku = IndukBuku::where('kode_buku', $request->kode_buku)->first();
            if($request->id_faktur_konsinyasi !== NULL){
                FakturKonsinyasi::insert([
                    'id_faktur_konsinyasi' => $request->id_faktur_konsinyasi,
                    'tb_induk_buku_kode_buku' => $request->kode_buku,
                    'qty' => $request->qty,
                    'discount' => $diskon,
                    'harga_satuan' => $request->harga_satuan,
                    'harga_total' => $harga_total,
                    'tgl_titip' => $now->format('Y-m-d'),
                    'tb_pelanggan_id' => $id_pelanggan,
                    'status_titip' => 0,
                    'status_terjual' => 0,
                    'is_obral' => $indukbuku->is_obral,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
            }else{
                $fakturterakhir = FakturKonsinyasi::select('id_faktur_konsinyasi')->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNST' . '%')->latest()->first();
                if($fakturterakhir === NULL){
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => 'FKTKNST1',
                        'tb_induk_buku_kode_buku' => $request->kode_buku,
                        'qty' => $request->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $request->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_pelanggan_id' => $id_pelanggan,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 0,
                        'status_terjual' => 0,
                        'is_obral' => $indukbuku->is_obral,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }else{
                    $id_faktur_konsinyasi = $fakturterakhir->id_faktur_konsinyasi;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_konsinyasi);
                    $id_faktur_konsinyasi = (int) $split[1] + 1;
                    $id_faktur_konsinyasi = 'FKTKNST' . $id_faktur_konsinyasi;
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => $id_faktur_konsinyasi,
                        'tb_induk_buku_kode_buku' => $request->kode_buku,
                        'qty' => $request->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $request->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_pelanggan_id' => $id_pelanggan,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 0,
                        'status_terjual' => 0,
                        'is_obral' => $indukbuku->is_obral,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }
            }
            $stok = Stok::find($request->kode_buku);
            $faktur = FakturKonsinyasi::select('id')->orderBy('id', 'desc')->first();
            $pelanggan = Pelanggan::where('id_pelanggan', $id_pelanggan)->first();
            Histori::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'id_transaksi' => 'FKT' . $faktur->id,
                'entitas' => $pelanggan->nama,
                'qty' => $request->qty,
                'status' => 0,
                'discount' => $diskon,
                'harga_satuan' => $request->harga_satuan,
                'harga_total' => $harga_total,
                'stok_awal' => $stok->qty,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $stok->qty =  $stok->qty - $request->qty;
            $stok->save();
        }else{
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
            $harga_total = $request->qty*$request->harga_satuan;
            $diskon = 0;
            date_default_timezone_set("Asia/Bangkok");
            $now = new DateTime();
            $indukbuku = IndukBuku::where('kode_buku', $request->kode_buku)->first();
            if($request->id_faktur_konsinyasi !== NULL){
                FakturKonsinyasi::insert([
                    'id_faktur_konsinyasi' => $request->id_faktur_konsinyasi,
                    'tb_induk_buku_kode_buku' => $request->kode_buku,
                    'qty' => $request->qty,
                    'discount' => $diskon,
                    'harga_satuan' => $request->harga_satuan,
                    'harga_total' => $harga_total,
                    'tb_supplier_id' => $id_supplier,
                    'tgl_titip' => $now->format('Y-m-d'),
                    'status_titip' => 1,
                    'status_terjual' => 0,
                    'is_obral' => $indukbuku->is_obral,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
            }else{
                $fakturterakhir = FakturKonsinyasi::select('id_faktur_konsinyasi')->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSP' . '%')->latest()->first();
                if($fakturterakhir === NULL){
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => 'FKTKNSP1',
                        'tb_induk_buku_kode_buku' => $request->kode_buku,
                        'qty' => $request->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $request->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_supplier_id' => $id_supplier,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 1,
                        'status_terjual' => 0,
                        'is_obral' => $indukbuku->is_obral,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }else{
                    $id_faktur_konsinyasi = $fakturterakhir->id_faktur_konsinyasi;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_konsinyasi);
                    $id_faktur_konsinyasi = (int) $split[1] + 1;
                    $id_faktur_konsinyasi = 'FKTKNSP' . $id_faktur_konsinyasi;
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => $id_faktur_konsinyasi,
                        'tb_induk_buku_kode_buku' => $request->kode_buku,
                        'qty' => $request->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $request->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_supplier_id' => $id_supplier,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 1,
                        'status_terjual' => 0,
                        'is_obral' => $indukbuku->is_obral,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }
                $stok = Stok::find($request->kode_buku);
                $faktur = FakturKonsinyasi::select('id')->orderBy('id', 'desc')->first();
                $supplier = Supplier::where('id_supplier', $id_supplier)->first();
                Histori::insert([
                    'tb_induk_buku_kode_buku' => $request->kode_buku,
                    'id_transaksi' => 'FKP' . $faktur->id,
                    'entitas' => $supplier->nm_supplier,
                    'qty' => $request->qty,
                    'status' => 0,
                    'discount' => $diskon,
                    'harga_satuan' => $request->harga_satuan,
                    'harga_total' => $harga_total,
                    'stok_awal' => $stok->qty,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
                $stok->qty =  $stok->qty + $request->qty;
                $stok->save();
            }
        }

        // alihkan halaman tambah buku ke halaman books
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.faktur.konsinyasi.list');
    }
    
    function showEditForm($id){
        if (Auth::user()->role === 0 || Auth::user()->role === 3 || Auth::user()->role === 1)
		{
			$indukbuku = IndukBuku::all();
            $faktur = FakturKonsinyasi::with(['indukbuku', 'pelanggan'])->where('id_penjualan_buku', $id)->first();
            return view('Admin.Konsinyasi.edit', compact(['indukbuku', 'faktur']));
		}
		else
		{
			abort(401);
		}
    }

    public function update(Request $request)
	{
        if($request->status_titip == 0){
            // insert data ke table books
            if($request->diskon !== NULL){
                $harga_diskon = ($request->diskon * ($request->qty*$request->harga_jual_satuan)) / 100;
                $harga_total = ($request->qty*$request->harga_jual_satuan) - $harga_diskon;
                $diskon = $request->diskon;
            }else{
                $harga_total = $request->qty*$request->harga_jual_satuan;
                $diskon = 0;
            }
            date_default_timezone_set("Asia/Bangkok");
            $now = new DateTime();
            $konsinyasi = FakturKonsinyasi::find($request->id_faktur_konsinyasi);
            $tempqty = $konsinyasi->qty;
            if($konsinyasi->tb_induk_buku_kode_buku == $request->kode_buku){
                $konsinyasi->qty = $request->qty;
                $konsinyasi->discount =  $diskon;
                $konsinyasi->harga_jual_satuan = $request->harga_satuan;
                $konsinyasi->harga_total = $harga_total;
                $konsinyasi->tb_pelanggan = $request->id_pelanggan;
                $konsinyasi->save();

                $stok = Stok::find($request->kode_buku);
                if($tempqty > $request->qty){
                    $stok->qty =  $stok->qty + ($tempqty - $request->qty);
                }else{
                    $stok->qty =  $stok->qty - ($request->qty - $tempqty);
                }
                $stok->save();
            }else{
                $stok = Stok::find($konsinyasi->tb_induk_buku_kode_buku);
                $stok->qty =  $stok->qty + $tempqty;

                $konsinyasi->tb_induk_buku_kode_buku = $request->kode_buku;
                $konsinyasi->qty = $request->qty;
                $konsinyasi->discount =  $diskon;
                $konsinyasi->harga_jual_satuan = $request->harga_satuan;
                $konsinyasi->harga_total = $harga_total;
                $konsinyasi->tb_pelanggan = $request->id_pelanggan;
                $konsinyasi->save();

                $stok = Stok::find($request->kode_buku);
                $stok->qty =  $stok->qty - $request->qty;
                $stok->save();
            }
        }else{

        }
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.faktur.konsinyasi.list');
    }

    function delete(Request $request){
        // $faktur = FakturKonsinyasi::where('id',$request->id)->first();
        // if($faktur->status_titip == 0){
        //     $stok = Stok::find($request->kode_buku);
        //     $stok->qty =  $stok->qty + $request->qty;
        //     $stok->save();
        // }else{
        //     $stok = Stok::find($request->kode_buku);
        //     $stok->qty =  $stok->qty - $request->qty;
        //     $stok->save();
        // }
        // $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
        $faktur = FakturKonsinyasi::where('id', $request->id)->first();
        if(str_contains($faktur->id_faktur_konsinyasi, 'FKTKNSU') != true && str_contains($faktur->id_faktur_konsinyasi, 'FKTKNSR') != true){
            if($faktur->status_titip == 0){
                $stok = Stok::find($faktur->tb_induk_buku_kode_buku);
                $stok->qty =  $stok->qty + $faktur->qty;
                $stok->save();
                $histori = Histori::where('id_transaksi', 'FKT'.$request->id)->first();
                $histori->status = 1;
                $histori->save();
                $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
            }else{
                $stok = Stok::find($faktur->tb_induk_buku_kode_buku);
                $stok->qty =  $stok->qty - $faktur->qty;
                $stok->save();
                $histori = Histori::where('id_transaksi', 'FKP'.$request->id)->first();
                $histori->status = 1;
                $histori->save();
                $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
            }
        }else{
            $faktur = FakturKonsinyasi::where('id_faktur_konsinyasi',$faktur->id_faktur_konsinyasi)->delete();
        }
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.faktur.konsinyasi.list');
    }

    function list(){
        if (Auth::user()->role === 0 || Auth::user()->role === 3 || Auth::user()->role === 1)
		{
			$faktur = FakturKonsinyasi::with(['indukbuku', 'pelanggan'])->orderBy('id_faktur_konsinyasi', 'ASC')->get();
            return view('Admin.Konsinyasi.list', compact(['faktur']));
		}
		else
		{
			abort(401);
		}
    }

    function cetak($id){
        if(strpos($id, 'FKTKNST') !== false || strpos($id, 'FKTKNSRT') !== false) {
            $faktur = FakturKonsinyasi::with(['indukbuku', 'pelanggan'])->where('id_faktur_konsinyasi', $id)->get();
            $fakturone = FakturKonsinyasi::with(['indukbuku', 'pelanggan'])->where('id_faktur_konsinyasi', $id)->first();
            return view('Admin.Konsinyasi.cetaktitip', compact(['faktur', 'fakturone']));
        }else{
            $faktur = FakturKonsinyasi::with(['indukbuku', 'supplier'])->where('id_faktur_konsinyasi', $id)->get();
            $fakturone = FakturKonsinyasi::with(['indukbuku', 'supplier'])->where('id_faktur_konsinyasi', $id)->first();
            return view('Admin.Konsinyasi.cetakterima', compact(['faktur', 'fakturone']));
        }
    }

    function showSoldForm($id){
        $indukbuku = IndukBuku::all();
        $pelanggan = Pelanggan::all();
        $faktur = FakturKonsinyasi::with(['indukbuku', 'pelanggan'])->where('id', $id)->first();
        return view('Admin.Konsinyasi.terjual', compact(['indukbuku', 'pelanggan', 'faktur']));
    }

    function sold(Request $request){
        if($request->status_titip == 0){
            $harga_satuan = 0;
            // insert data ke table books
            $data = Pelanggan::select('id_pelanggan')->where('id_pelanggan', $request->id_pelanggan)->first();
            $id_pelanggan = $data->id_pelanggan;
            // insert data ke table books
            if($request->diskon !== NULL){
                $harga_diskon = ($request->diskon * ($request->qty*$request->harga_satuan)) / 100;
                $harga_total = ($request->qty*$request->harga_satuan) - $harga_diskon;
                $diskon = $request->diskon;
            }else{
                $harga_total = $request->qty*$request->harga_satuan;
                $diskon = 0;
            }
            date_default_timezone_set("Asia/Bangkok");
            $now = new DateTime();
            $faktur = FakturKonsinyasi::where('id', $request->id)->first();
            JualBuku::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'tb_pelanggan_id' => $id_pelanggan,
                'qty' => $request->qty,
                'discount' => $diskon,
                'harga_jual_satuan' => $request->harga_satuan,
                'harga_total' => $harga_total,
                'total_non_diskon' => $request->harga_satuan*$request->qty,
                'status_royalti' => 0,
                'status_penjualan' => 0,
                'is_obral' => $faktur->is_obral,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $data = JualBuku::select('id_penjualan_buku')->orderBy('id_penjualan_buku', 'desc')->first();
            $id_penjualan = $data->id_penjualan_buku;
            $stok = Stok::find($request->kode_buku);
            $pelanggan = Pelanggan::where('id_pelanggan', $id_pelanggan)->first();
            Histori::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'id_transaksi' => 'J' . $id_penjualan,
                'entitas' => $pelanggan->nama,
                'qty' => $request->qty,
                'status' => 0,
                'discount' => $diskon,
                'harga_satuan' => $request->harga_satuan,
                'harga_total' => $harga_total,
                'stok_awal' => $stok->qty,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $datajual = JualBuku::select('tb_penjualan_buku.id_penjualan_buku as id_penjualan_buku', 'tb_penjualan_buku.updated_at as updated_at')->where('tb_penjualan_buku.tb_pelanggan_id', $id_pelanggan)
                        ->join('tb_faktur_penjualan','tb_faktur_penjualan.tb_penjualan_buku_id','=','tb_penjualan_buku.id_penjualan_buku')
                        ->where('tb_faktur_penjualan.id_faktur_penjualan', 'like', '%FKTJBT%')
                        ->where('tb_penjualan_buku.updated_at', 'like', date('Y-m-d').'%')
                        ->orderBy('tb_penjualan_buku.updated_at', 'desc')
                        ->first();
            if($datajual != NULL){
                $faktur = FakturJual::where('tb_penjualan_buku_id', $datajual->id_penjualan_buku)->first();
                FakturJual::insert([
                    'id_faktur_penjualan' => $faktur->id_faktur_penjualan,
                    'tb_penjualan_buku_id' => $id_penjualan,
                    'status_bayar' => 1
                ]);
            }else{
                $fakturterakhir = FakturJual::select('id_faktur_penjualan')->where('id_faktur_penjualan', 'like', '%FKTJBT%')->orderBy('id_faktur_penjualan', 'desc')->first();
                if($fakturterakhir === NULL){
                    FakturJual::insert([
                        'id_faktur_penjualan' => 'FKTJBT1',
                        'tb_penjualan_buku_id' => $id_penjualan,
                        'status_bayar' => 1
                    ]);
                }else{
                    $id_faktur_penjualan = $fakturterakhir->id_faktur_penjualan;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_penjualan);
                    $id_faktur_penjualan = (int) $split[1] + 1;
                    $id_faktur_penjualan = 'FKTJBT' . $id_faktur_penjualan;
                    FakturJual::insert([
                        'id_faktur_penjualan' => $id_faktur_penjualan,
                        'tb_penjualan_buku_id' => $id_penjualan,
                        'status_bayar' => 1
                    ]);
                }
            }
            $faktur = FakturJual::select('id')->orderBy('id', 'desc')->where('id_faktur_penjualan', 'like', '%FKTJBT%')->first();
            $id_faktur = $faktur->id;
            date_default_timezone_set("Asia/Bangkok");
            $now = new DateTime();
            // KasKeluar::insert([
            //     'tb_penjualan_buku_id' => $id_penjualan,
            //     'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
            //     'note' => "Royalti",
            //     'kredit_kas_keluar' => (($request->harga_satuan*$request->qty) * 10) / 100,
            //     'created_at' => $now->format('Y-m-d H:i:s'),
            //     'updated_at' => $now->format('Y-m-d H:i:s')
            // ]);
            $indukbuku = IndukBuku::with(['pengarang'])->where('kode_buku', $request->kode_buku)->first();
            JurnalUmum::insert([
                'tb_penjualan_buku_id' => $id_penjualan,
                'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                'debit_kredit_royalti' => (($request->harga_satuan*$request->qty) * $indukbuku->pengarang->persen_royalti) / 100,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            KasMasuk::insert([
                'tb_faktur_penjualan_id' => $id_faktur,
                'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                'note' => "Tunai",
                'debit_kas_masuk' => $harga_total,
                'kredit_penjualan' => $harga_total,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            // $faktur = FakturKonsinyasi::where('id', $request->id)->first();
            // if($faktur->qty - $request->qty !== 0){
            //     $stok->qty =  $stok->qty + ($faktur->qty - $request->qty);
            //     $stok->save();
            // }
            // $histori = Histori::where('id_transaksi', 'FKT'.$request->id)->first();
            // $histori->status = 1;
            // $histori->save();
            // $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
            $faktur = FakturKonsinyasi::where('id', $request->id)->first();
            $faktur->qty =  $faktur->qty - $request->qty;
            if($faktur->diskon !== NULL){
                $harga_diskon = ($faktur->diskon * ($faktur->qty*$faktur->harga_satuan)) / 100;
                $harga_total = ($faktur->qty*$faktur->harga_satuan) - $harga_diskon;
                $diskon = $faktur->diskon;
            }else{
                $harga_total = $faktur->qty*$faktur->harga_satuan;
                $diskon = 0;
            }
            $histori = Histori::where('id_transaksi', 'FKT' . $request->id)->first();
            $histori->qty -= $request->qty;
            $histori->save();
            $faktur->harga_total =  $harga_total;
            $faktur->save();
            Alert::success('Success', 'Data berhasil masuk ke penjualan');
        }else{
            $harga_satuan = 0;
            // insert data ke table books
            $data = Supplier::select('id_supplier')->where('id_supplier', $request->id_supplier)->first();
            $id_supplier = $data->id_supplier;
            // insert data ke table books
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            BeliBuku::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'tb_supplier_id' => $id_supplier,
                'qty' => $request->qty,
                'harga_beli_satuan' => $request->harga_satuan,
                'total_harga' => $request->qty*$request->harga_satuan,
                'note' => "Konsinyasi",
                'tgl_ppn' => $now->format('Y-m-d'),
                'status_pembelian' => 0,
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
                'harga_satuan' => $request->harga_satuan,
                'harga_total' => $request->qty*$request->harga_satuan,
                'stok_awal' => $stok->qty,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
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
                'debit_pembelian' => $request->qty*$request->harga_satuan,
                'kredit_kas_keluar' => $request->qty*$request->harga_satuan,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $datakonsinyasi = FakturKonsinyasi::where('tb_supplier_id', $id_supplier)
                        ->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSU' . '%')
                        ->get();
            $valid = 0;
            if(count($datakonsinyasi) > 0){
                foreach($datakonsinyasi as $data){
                    if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0){
                        FakturKonsinyasi::insert([
                            'id_faktur_konsinyasi' => $data->id_faktur_konsinyasi,
                            'tb_induk_buku_kode_buku' => $request->kode_buku,
                            'qty' => $request->qty,
                            'discount' => 0,
                            'harga_satuan' => $request->harga_satuan,
                            'harga_total' => $request->qty*$request->harga_satuan,
                            'tb_supplier_id' => $id_supplier,
                            'tgl_titip' => $now->format('Y-m-d'),
                            'status_titip' => 1,
                            'status_terjual' => 1,
                            'created_at' => $now->format('Y-m-d H:i:s'),
                            'updated_at' => $now->format('Y-m-d H:i:s')
                        ]);
                        $valid = 1;
                    }
                }
            }else{
                $fakturterakhir = FakturKonsinyasi::select('id_faktur_konsinyasi')->orderBy('id_faktur_konsinyasi', 'desc')->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSU' . '%')->first();
                if($fakturterakhir === NULL){
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => 'FKTKNSU1',
                        'tb_induk_buku_kode_buku' => $request->kode_buku,
                        'qty' => $request->qty,
                        'discount' => 0,
                        'harga_satuan' => $request->harga_satuan,
                        'harga_total' => $request->qty*$request->harga_satuan,
                        'tb_supplier_id' => $id_supplier,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 1,
                        'status_terjual' => 1,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }else{
                    $id_faktur_konsinyasi = $fakturterakhir->id_faktur_konsinyasi;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_konsinyasi);
                    $id_faktur_konsinyasi = (int) $split[1] + 1;
                    $id_faktur_konsinyasi = 'FKTKNSU' . $id_faktur_konsinyasi;
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => $id_faktur_konsinyasi,
                        'tb_induk_buku_kode_buku' => $request->kode_buku,
                        'qty' => $request->qty,
                        'discount' => 0,
                        'harga_satuan' => $request->harga_satuan,
                        'harga_total' => $request->qty*$request->harga_satuan,
                        'tb_supplier_id' => $id_supplier,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 1,
                        'status_terjual' => 1,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }
            }
            // $fakturterakhir = FakturKonsinyasi::select('id_faktur_konsinyasi')->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSU' . '%')->latest()->first();
            // if($fakturterakhir === NULL){
            //     FakturKonsinyasi::insert([
            //         'id_faktur_konsinyasi' => 'FKTKNSU1',
            //         'tb_induk_buku_kode_buku' => $request->kode_buku,
            //         'qty' => $request->qty,
            //         'discount' => 0,
            //         'harga_satuan' => $request->harga_satuan,
            //         'harga_total' => $request->qty*$request->harga_satuan,
            //         'tb_supplier_id' => $id_supplier,
            //         'tgl_titip' => $now->format('Y-m-d'),
            //         'status_titip' => 1,
            //         'status_terjual' => 1,
            //         'created_at' => $now->format('Y-m-d H:i:s'),
            //         'updated_at' => $now->format('Y-m-d H:i:s')
            //     ]);
            // }else{
            //     $id_faktur_konsinyasi = $fakturterakhir->id_faktur_konsinyasi;
            //     $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_konsinyasi);
            //     $id_faktur_konsinyasi = (int) $split[1] + 1;
            //     $id_faktur_konsinyasi = 'FKTKNSU' . $id_faktur_konsinyasi;
            //     FakturKonsinyasi::insert([
            //         'id_faktur_konsinyasi' => $id_faktur_konsinyasi,
            //         'tb_induk_buku_kode_buku' => $request->kode_buku,
            //         'qty' => $request->qty,
            //         'discount' => 0,
            //         'harga_satuan' => $request->harga_satuan,
            //         'harga_total' => $request->qty*$request->harga_satuan,
            //         'tb_supplier_id' => $id_supplier,
            //         'tgl_titip' => $now->format('Y-m-d'),
            //         'status_titip' => 1,
            //         'status_terjual' => 1,
            //         'created_at' => $now->format('Y-m-d H:i:s'),
            //         'updated_at' => $now->format('Y-m-d H:i:s')
            //     ]);
            // }
            // $faktur = FakturKonsinyasi::where('id', $request->id)->first();
            // // var_dump($faktur->qty - $request->qty);
            // if($faktur->qty - $request->qty !== 0){
            //     $stok->qty =  $stok->qty - ($faktur->qty - $request->qty);
            //     $stok->save();
            // }
            // $histori = Histori::where('id_transaksi', 'FKP' . $request->id)->first();
            // $histori->status = 1;
            // $histori->save();
            // $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
            $histori = Histori::where('id_transaksi', 'FKP' . $request->id)->first();
            $histori->qty -= $request->qty;
            $histori->save();
            $faktur = FakturKonsinyasi::where('id', $request->id)->first();
            $faktur->qty =  $faktur->qty - $request->qty;
            $faktur->harga_total =  $faktur->harga_satuan * ($faktur->qty - $request->qty);
            // $stok->save();
            $faktur->save();
            Alert::success('Success', 'Data berhasil masuk ke pembelian');
        }
        return redirect()->route('admin.faktur.konsinyasi.list');
    }

    function notSold(Request $request){
        $faktur = FakturKonsinyasi::where('id', $request->id)->first();
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        if($faktur->status_titip == 0){
            $stok = Stok::find($faktur->tb_induk_buku_kode_buku);
            $stok->qty =  $stok->qty + $faktur->qty;
            $stok->save();
            $histori = Histori::where('id_transaksi', 'FKT'.$request->id)->first();
            $histori->status = 1;
            $histori->save();
            $datakonsinyasi = FakturKonsinyasi::where('tb_supplier_id', $faktur->tb_supplier_id)
                        ->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSRT' . '%')
                        ->get();
            $valid = 0;
            if($faktur->discount !== NULL){
                $harga_diskon = ($faktur->discount * ($faktur->qty*$faktur->harga_satuan)) / 100;
                $harga_total = ($faktur->qty*$faktur->harga_satuan) - $harga_diskon;
                $diskon = $faktur->discount;
            }else{
                $harga_total = $faktur->qty*$faktur->harga_satuan;
                $diskon = 0;
            }
            if(count($datakonsinyasi) > 0){
                foreach($datakonsinyasi as $data){
                    if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0){
                        FakturKonsinyasi::insert([
                            'id_faktur_konsinyasi' => $data->id_faktur_konsinyasi,
                            'tb_induk_buku_kode_buku' => $faktur->tb_induk_buku_kode_buku,
                            'tb_pelanggan_id' => $faktur->tb_pelanggan_id,
                            'qty' => $faktur->qty,
                            'discount' => $diskon,
                            'harga_satuan' => $faktur->harga_satuan,
                            'harga_total' => $harga_total,
                            'tb_supplier_id' => $faktur->tb_supplier_id,
                            'tgl_titip' => $now->format('Y-m-d'),
                            'status_titip' => 0,
                            'status_terjual' => 0,
                            'created_at' => $now->format('Y-m-d H:i:s'),
                            'updated_at' => $now->format('Y-m-d H:i:s')
                        ]);
                        $valid = 1;
                    }
                }
            }else{
                $fakturterakhir = FakturKonsinyasi::select('id_faktur_konsinyasi')->orderBy('id_faktur_konsinyasi', 'desc')->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSRT' . '%')->first();
                if($fakturterakhir === NULL){
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => 'FKTKNSRT1',
                        'tb_induk_buku_kode_buku' => $faktur->tb_induk_buku_kode_buku,
                        'tb_pelanggan_id' => $faktur->tb_pelanggan_id,
                        'qty' => $faktur->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $faktur->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_supplier_id' => $faktur->tb_supplier_id,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 0,
                        'status_terjual' => 0,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }else{
                    $id_faktur_konsinyasi = $fakturterakhir->id_faktur_konsinyasi;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_konsinyasi);
                    $id_faktur_konsinyasi = (int) $split[1] + 1;
                    $id_faktur_konsinyasi = 'FKTKNSRT' . $id_faktur_konsinyasi;
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => $id_faktur_konsinyasi,
                        'tb_induk_buku_kode_buku' => $faktur->tb_induk_buku_kode_buku,
                        'tb_pelanggan_id' => $faktur->tb_pelanggan_id,
                        'qty' => $faktur->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $faktur->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_supplier_id' => $faktur->tb_supplier_id,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 0,
                        'status_terjual' => 0,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }
            }
            $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
            Alert::success('Success', 'Data berhasil dikembalikan ke induk buku');
        }else{
            $stok = Stok::find($faktur->tb_induk_buku_kode_buku);
            $stok->qty =  $stok->qty - $faktur->qty;
            $stok->save();
            $histori = Histori::where('id_transaksi', 'FKP'.$request->id)->first();
            $histori->status = 1;
            $histori->save();
            $datakonsinyasi = FakturKonsinyasi::where('tb_supplier_id', $faktur->tb_supplier_id)
                        ->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSRP' . '%')
                        ->get();
            $valid = 0;
            $harga_total = $faktur->qty*$faktur->harga_satuan;
            $diskon = 0;
            if(count($datakonsinyasi) > 0){
                foreach($datakonsinyasi as $data){
                    if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0){
                        FakturKonsinyasi::insert([
                            'id_faktur_konsinyasi' => $data->id_faktur_konsinyasi,
                            'tb_induk_buku_kode_buku' => $faktur->tb_induk_buku_kode_buku,
                            'qty' => $faktur->qty,
                            'discount' => $diskon,
                            'harga_satuan' => $faktur->harga_satuan,
                            'harga_total' => $harga_total,
                            'tb_supplier_id' => $faktur->tb_supplier_id,
                            'tgl_titip' => $now->format('Y-m-d'),
                            'status_titip' => 1,
                            'status_terjual' => 0,
                            'created_at' => $now->format('Y-m-d H:i:s'),
                            'updated_at' => $now->format('Y-m-d H:i:s')
                        ]);
                        $valid = 1;
                    }
                }
            }else{
                $fakturterakhir = FakturKonsinyasi::select('id_faktur_konsinyasi')->orderBy('id_faktur_konsinyasi', 'desc')->where('id_faktur_konsinyasi', 'like', '%' . 'FKTKNSRP' . '%')->first();
                if($fakturterakhir === NULL){
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => 'FKTKNSRP1',
                        'tb_induk_buku_kode_buku' => $faktur->tb_induk_buku_kode_buku,
                        'qty' => $faktur->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $faktur->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_supplier_id' => $faktur->tb_supplier_id,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 1,
                        'status_terjual' => 0,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }else{
                    $id_faktur_konsinyasi = $fakturterakhir->id_faktur_konsinyasi;
                    $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_konsinyasi);
                    $id_faktur_konsinyasi = (int) $split[1] + 1;
                    $id_faktur_konsinyasi = 'FKTKNSRP' . $id_faktur_konsinyasi;
                    FakturKonsinyasi::insert([
                        'id_faktur_konsinyasi' => $id_faktur_konsinyasi,
                        'tb_induk_buku_kode_buku' => $faktur->tb_induk_buku_kode_buku,
                        'qty' => $faktur->qty,
                        'discount' => $diskon,
                        'harga_satuan' => $faktur->harga_satuan,
                        'harga_total' => $harga_total,
                        'tb_supplier_id' => $faktur->tb_supplier_id,
                        'tgl_titip' => $now->format('Y-m-d'),
                        'status_titip' => 1,
                        'status_terjual' => 0,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                }
            }
            $faktur = FakturKonsinyasi::where('id',$request->id)->delete();
            Alert::success('Success', 'Data berhasil dihilangkan dan Buku harap dikembalikan');
        }
        return redirect()->route('admin.faktur.konsinyasi.list');
    }
}
