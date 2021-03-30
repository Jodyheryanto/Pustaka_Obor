<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use DateTime;
use DB;
use App\Models\City;
use App\Models\JualBuku;
use App\Models\IndukBuku;
use App\Models\Pelanggan;
use App\Models\Salesman;
use App\Models\Stok;
use App\Models\Histori;
use App\Models\FakturJual;
use App\Models\JurnalJual;
use App\Models\JurnalUmum;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\KasLain2;
use GuzzleHttp\Client;

class AdminJualBukuController extends Controller
{
    function showCreateForm(){
        $indukbuku = IndukBuku::all();
        $buku1 = IndukBuku::select('tb_induk_buku.harga_jual', 'tb_induk_buku.is_obral')
            ->join('tb_stock','tb_stock.tb_induk_buku_kode_buku','=','tb_induk_buku.kode_buku')
            ->where('tb_stock.qty', '>', 0)->orderBy('kode_buku', 'ASC')
            ->first();
        $max = IndukBuku::with(['stock'])->join('tb_stock','tb_stock.tb_induk_buku_kode_buku','=','tb_induk_buku.kode_buku')
            ->where('tb_stock.qty', '>', 0)->orderBy('kode_buku', 'ASC')
            ->first();
        if($max === NULL){
            $max_qty = 0;
        }else{
            $max_qty = $max->stock->qty;
        }
        $pelanggan = Pelanggan::all();
        $salesman = Salesman::all();
        $cities = City::pluck('name', 'id');
        return view('Admin.JualBuku.create', compact(['max_qty', 'indukbuku', 'pelanggan', 'salesman', 'cities', 'buku1']));
    }

    public function create(Request $request)
	{
        if (Auth::user()->role === 2 || Auth::user()->role === 0)
		{
			$id_pelanggan = $request->id_pelanggan;
            $id_salesman = $request->id_salesman;
            $harga_satuan = 0;
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
                    'tanggal_lahir' => $request->tanggal_lahir_pelanggan,
                    'discount' => $request->diskon_pelanggan
                ]);
                $data = Pelanggan::select('id_pelanggan')->orderBy('id_pelanggan', 'desc')->first();
                $id_pelanggan = $data->id_pelanggan;
            }
            if($request->id_salesman === NULL){
                Salesman::insert([
                    'nama' => $request->nm_salesman
                ]);
                $data = Salesman::select('id_salesman')->orderBy('id_salesman', 'desc')->first();
                $id_salesman = $data->id_salesman;
            }
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
            JualBuku::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'tb_salesman_id' => $id_salesman,
                'tb_pelanggan_id' => $id_pelanggan,
                'qty' => $request->qty,
                'discount' => $diskon,
                'harga_jual_satuan' => $request->harga_jual_satuan,
                'harga_total' => $harga_total,
                'total_non_diskon' => $request->harga_jual_satuan*$request->qty,
                'status_royalti' => 0,
                'is_obral' => $request->status_jual,
                'status_penjualan' => $request->status_penjualan,
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
                'harga_satuan' => $request->harga_jual_satuan,
                'harga_total' => $harga_total,
                'stok_awal' => $stok->qty,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $stok->qty =  $stok->qty - $request->qty;
            $stok->save();
            if($request->status_penjualan == 0){
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
                //     'kredit_kas_keluar' => (($request->harga_jual_satuan*$request->qty) * 10) / 100,
                //     'created_at' => $now->format('Y-m-d H:i:s'),
                //     'updated_at' => $now->format('Y-m-d H:i:s')
                // ]);
                $indukbuku = IndukBuku::with(['pengarang'])->where('kode_buku', $request->kode_buku)->first();
                JurnalUmum::insert([
                    'tb_penjualan_buku_id' => $id_penjualan,
                    'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                    'debit_kredit_royalti' => (($request->harga_jual_satuan*$request->qty) * $indukbuku->pengarang->persen_royalti) / 100,
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
            }else{
                $datajual = JualBuku::select('tb_penjualan_buku.id_penjualan_buku as id_penjualan_buku', 'tb_penjualan_buku.updated_at as updated_at')->where('tb_penjualan_buku.tb_pelanggan_id', $id_pelanggan)
                            ->join('tb_faktur_penjualan','tb_faktur_penjualan.tb_penjualan_buku_id','=','tb_penjualan_buku.id_penjualan_buku')
                            ->where('tb_faktur_penjualan.id_faktur_penjualan', 'like', '%FKTJBN%')
                            ->where('tb_penjualan_buku.updated_at', 'like', date('Y-m-d').'%')
                            ->orderBy('tb_penjualan_buku.updated_at', 'desc')
                            ->first();
                if($datajual != NULL){
                    $faktur = FakturJual::where('tb_penjualan_buku_id', $datajual->id_penjualan_buku)->first();
                    FakturJual::insert([
                        'id_faktur_penjualan' => $faktur->id_faktur_penjualan,
                        'tb_penjualan_buku_id' => $id_penjualan,
                        'status_bayar' => 0
                    ]);
                }else{
                    $fakturterakhir = FakturJual::select('id_faktur_penjualan')->where('id_faktur_penjualan', 'like', '%FKTJBN%')->orderBy('id_faktur_penjualan', 'desc')->first();
                    if($fakturterakhir === NULL){
                        FakturJual::insert([
                            'id_faktur_penjualan' => 'FKTJBN1',
                            'tb_penjualan_buku_id' => $id_penjualan,
                            'status_bayar' => 0
                        ]);
                    }else{
                        $id_faktur_penjualan = $fakturterakhir->id_faktur_penjualan;
                        $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_penjualan);
                        $id_faktur_penjualan = (int) $split[1] + 1;
                        $id_faktur_penjualan = 'FKTJBN' . $id_faktur_penjualan;
                        FakturJual::insert([
                            'id_faktur_penjualan' => $id_faktur_penjualan,
                            'tb_penjualan_buku_id' => $id_penjualan,
                            'status_bayar' => 0
                        ]);
                    }
                }
                $faktur = FakturJual::select('id')->orderBy('id', 'desc')->where('id_faktur_penjualan', 'like', '%FKTJBN%')->first();
                $id_faktur = $faktur->id;
                $pelanggan = Pelanggan::where('id_pelanggan', $id_pelanggan)->first();
                date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
                JurnalJual::insert([
                    'tb_faktur_penjualan_id' => $id_faktur,
                    'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                    'pelanggan' => $pelanggan->nama,
                    'syarat_pembayaran' => "ini non tunai",
                    'debit_piutang' => $harga_total,
                    'kredit_penjualan' => $harga_total,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
            }
            // $request->session()->put('tgl_selesai', $request->tgl_selesai . ' 00:00:00');

            // alihkan halaman tambah buku ke halaman books
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->route('admin.inventori.penjualan-buku.list');
            // ->with('success', 'Course successfully created!');
		}
		else
		{
			abort(401);
		}
    }
    
    function showEditForm($id){
        if (Auth::user()->role === 2 || Auth::user()->role === 0)
		{
			$indukbuku = IndukBuku::all();
            $pelanggan = Pelanggan::all();
            $salesman = Salesman::all();
            $jualbuku = JualBuku::with(['indukbuku'])->where('id_penjualan_buku', $id)->first();
            return view('Admin.JualBuku.edit', compact(['indukbuku', 'salesman', 'pelanggan', 'jualbuku']));
		}
		else
		{
			abort(401);
		}
    }

    public function update(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        // insert data ke table books
        if($request->diskon !== NULL){
            $harga_diskon = ($request->diskon * ($request->qty*$request->harga_jual_satuan)) / 100;
            $harga_total = ($request->qty*$request->harga_jual_satuan) - $harga_diskon;
            $diskon = $request->diskon;
        }else{
            $harga_total = $request->qty*$request->harga_jual_satuan;
            $diskon = 0;
        }
        $jualbuku = JualBuku::find($request->id_penjualan_buku);
        $tempqty = $jualbuku->qty;
        if($jualbuku->tb_induk_buku_kode_buku == $request->kode_buku){
            $jualbuku->tb_salesman_id = $request->id_salesman;
            $jualbuku->tb_pelanggan_id = $request->id_pelanggan;
            $jualbuku->qty = $request->qty;
            $jualbuku->discount =  $diskon;
            $jualbuku->harga_jual_satuan = $request->harga_jual_satuan;
            $jualbuku->harga_total = $harga_total;
            $jualbuku->updated_at = $now->format('Y-m-d H:i:s');
            $jualbuku->save();

            $stok = Stok::find($request->kode_buku);
            if($tempqty > $request->qty){
                $stok->qty =  $stok->qty + ($tempqty - $request->qty);
            }else{
                $stok->qty =  $stok->qty - ($request->qty - $tempqty);
            }
            $stok->save();
        }else{
            $stok = Stok::find($jualbuku->tb_induk_buku_kode_buku);
            $stok->qty =  $stok->qty + $tempqty;
            
            $jualbuku->tb_induk_buku_kode_buku = $request->kode_buku;
            $jualbuku->tb_salesman_id = $request->id_salesman;
            $jualbuku->tb_pelanggan_id = $request->id_pelanggan;
            $jualbuku->qty = $request->qty;
            $jualbuku->discount =  $diskon;
            $jualbuku->harga_jual_satuan = $request->harga_jual_satuan;
            $jualbuku->harga_total = $harga_total;
            $jualbuku->save();

            $stok = Stok::find($request->kode_buku);
            $stok->qty =  $stok->qty - $request->qty;
            $stok->save();
        }
        
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.inventori.penjualan-buku.list');
    }

    public function ubahstatus(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        $jualbuku = JualBuku::find($request->id);
        $jualbuku->status_penjualan = $request->status;
        $jualbuku->updated_at = $now->format('Y-m-d H:i:s');
        $jualbuku->save();
        // Alert::success('Success', $request->input('id'));die;
        $pelanggan = JualBuku::select('tb_pelanggan_id')->where('id_penjualan_buku', $request->id)->first();
        $datajual = JualBuku::where('tb_pelanggan_id', $pelanggan->tb_pelanggan_id)->get();
        $valid = 0;
        if($request->status == 0){
            foreach($datajual as $data){
            // var_dump($data->updated_at['date']);die;
                if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0){
                    $faktur = FakturJual::where('tb_penjualan_buku_id', $request->id)->first();
                    if($faktur !== NULL){
                        FakturJual::insert([
                            'id_faktur_penjualan' => $faktur->id_faktur_penjualan,
                            'tb_penjualan_buku_id' => $request->id
                        ]);
                    }else{
                        $fakturterakhir = FakturJual::select('id_faktur_penjualan')->orderBy('id_faktur_penjualan', 'desc')->first();
                        if($fakturterakhir === NULL){
                            FakturJual::insert([
                                'id_faktur_penjualan' => 'FKTJB1',
                                'tb_penjualan_buku_id' => $request->id
                            ]);
                        }else{
                            $id_faktur_penjualan = $fakturterakhir->id_faktur_penjualan;
                            $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_penjualan);
                            $id_faktur_penjualan = (int) $split[1] + 1;
                            $id_faktur_penjualan = 'FKTJB' . $id_faktur_penjualan;
                            FakturJual::insert([
                                'id_faktur_penjualan' => $id_faktur_penjualan,
                                'tb_penjualan_buku_id' => $request->id
                            ]);
                        }
                    }
                    $valid = 1;
                }
            }
        }else{
            $datafaktur = FakturJual::where('tb_penjualan_buku_id', $request->id)->delete();
        }
    }

    function delete(Request $request){
        $returjual = 0;
        $jualbuku = JualBuku::with('returdetail')->where('id_penjualan_buku',$request->id_penjualan_buku)->first();
        $stok = Stok::find($request->kode_buku);
        if(count($jualbuku->returdetail) > 0){
            foreach($jualbuku->returdetail as $data){
                $returjual += $data->qty;
                $histori = Histori::where('id_transaksi','RJ'.$data->id_retur_penjualan)->first();
                $histori->status =  1;
                $histori->save();
            }
        }
        $histori = Histori::where('id_transaksi','J'.$request->id_penjualan_buku)->first();
        $histori->status =  1;
        $histori->save();
        $stok->qty =  $stok->qty + ($request->qty_jual - $returjual);
        $stok->save();
        $jualbuku = JualBuku::where('id_penjualan_buku',$request->id_penjualan_buku)->delete();

        $isifaktur = FakturJual::where('id_faktur_penjualan', $request->id_faktur)->count();
        $cekongkir = KasLain2::where('id_faktur', $request->id_faktur)->count();
        if($cekongkir > 0 && $isifaktur == 0){
            $hapusongkir = KasLain2::where('id_faktur', $request->id_faktur)->delete();
        }
        
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.inventori.penjualan-buku.list');
    }

    function list(){
        $fakturdb = FakturJual::with(['jualbuku'])->get();
        $myArray = array();
        $faktur = array();
        $i = -1;
        foreach($fakturdb as $data){
            $myArray[] = array('id_faktur' => $data->id_faktur_penjualan, 'nama_pelanggan' => $data->jualbuku->pelanggan->nama, 'tgl_faktur' => $data->jualbuku->updated_at);
        }
        usort($myArray, function($a, $b) {
            return $a['id_faktur'] <=> $b['id_faktur'];
        });
        foreach($myArray as $data){
            if($data !== NULL){
                if($i === -1){
                    $faktur[] = array('id_faktur' => $data['id_faktur'], 'nama_pelanggan' => $data['nama_pelanggan'], 'tgl_faktur' => $data['tgl_faktur']);
                    $i++;
                }
                if($faktur[$i]['id_faktur'] !== $data['id_faktur']){
                    $faktur[] = array('id_faktur' => $data['id_faktur'], 'nama_pelanggan' => $data['nama_pelanggan'], 'tgl_faktur' => $data['tgl_faktur']);
                    $i++;
                }
            }
        }
        $jualbuku = JualBuku::with(['indukbuku', 'salesman', 'pelanggan', 'fakturjual'])->get();
        return view('Admin.JualBuku.list', compact(['jualbuku', 'faktur']));
    }

    public function getInfo($id)
    {
        $fill = JualBuku::with(['indukbuku', 'returdetail', 'pelanggan', 'salesman'])->where('id_penjualan_buku', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }

    public function getFaktur($id)
    {
        $fill = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $id)->get();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }

    function cetak(Request $request){
        $id_faktur = $request->session()->get('id_faktur');
        $ongkir = KasLain2::where('id_faktur', $id_faktur)->where('kredit', '<>' , 0)->first();
        if($ongkir != NULL){
            $ongkir = $ongkir->kredit;
        }else{
            $ongkir = 0;
        }
        $faktur = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $id_faktur)->get();
        $fakturCount = count($faktur);
        $dataLunas = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $id_faktur)->where('status_bayar', 1)->count();
        $fakturone = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $id_faktur)->first();
        return view('Admin.JualBuku.cetak', compact(['faktur', 'fakturone', 'fakturCount', 'dataLunas', 'ongkir']));
    }

    function showOngkirForm(Request $request){
        $request->session()->put('id_faktur', $request->id_faktur);
        $cekongkir = KasLain2::where('id_faktur', $request->id_faktur)->count();
        if($cekongkir > 0){
            $request->session()->put('id_faktur', $request->id_faktur);
            return redirect()->route('admin.inventori.penjualan-buku.cetak-faktur');
        }else{
            $fakturone = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $request->id_faktur)->first();
            $faktur = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $request->id_faktur)->get();
            $fakturCount = count($faktur);
            $berat_total = 0;
            foreach($faktur as $data){
                $berat_total += $data->jualbuku->indukbuku->berat * $data->jualbuku->qty;
            }

            $kota = RajaOngkir::kota()->all();

            return view('Admin.JualBuku.cekongkir', compact(['faktur', 'fakturone', 'fakturCount', 'berat_total', 'kota']));
        }
    }

    function cekOngkir(Request $request){
        $request->session()->put('id_faktur', $request->id_faktur);
        $cekongkir = KasLain2::where('id_faktur', $request->id_faktur)->count();
        if($cekongkir == 0){
            if($request->jenis_pengiriman == 'jneoke' || $request->jenis_pengiriman == 'jneregb' || $request->jenis_pengiriman == 'jnereg' || $request->jenis_pengiriman == 'jneyes'){
                $id_account = 'BB00001';
            }elseif($request->jenis_pengiriman == 'tikions' || $request->jenis_pengiriman == 'tikireg' || $request->jenis_pengiriman == 'tikieco'){
                $id_account = 'BB00002';
            }elseif($request->jenis_pengiriman == 'pospkk' || $request->jenis_pengiriman == 'posq9' || $request->jenis_pengiriman == 'posex'){
                $id_account = 'BB00003';
            }elseif($request->jenis_pengiriman == 'ojol'){
                $id_account = 'BB00004';
            }else{
                $id_account = 'NB';
            }
            if(str_contains($request->id_faktur, 'FKTJBN')){
                $bayar = 0;
            }else{
                $bayar = 1;
            }
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            if(str_contains($request->id_faktur, 'FKTJBT') || $request->jenis_pengiriman == 'tanpakirim'){
                KasLain2::insert([
                    'tb_data_account_id' => $id_account,
                    'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                    'debit' => $request->total_ongkir,
                    'kredit' => 0,
                    'note' => 'Ongkos Kirim ' . $request->jenis_pengiriman . ' ' . $request->id_faktur,
                    'id_faktur' => $request->id_faktur,
                    'is_bayar' => $bayar
                ]);
            }

            KasLain2::insert([
                'tb_data_account_id' => $id_account,
                'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                'debit' => 0,
                'kredit' => $request->total_ongkir,
                'note' => 'Ongkos Kirim ' . $request->jenis_pengiriman . ' ' . $request->id_faktur,
                'id_faktur' => $request->id_faktur,
                'is_bayar' => $bayar
            ]);
        }

        return redirect()->route('admin.inventori.penjualan-buku.cetak-faktur');
    }

    public function info_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin, // ID kota/kabupaten asal
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();


        return response()->json($cost);
    }

    public function filter(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        $kode = $request->kode_analisa;
        if($request->kode_analisa == 0){
            $indukbuku = IndukBuku::with(['jualqtyhigh'])->get();
            $arrBuku = array();
            foreach($indukbuku as $data){
                if($data->jualqtyhigh != NULL){
                    $arrBuku[] = array('kode_buku' => $data->kode_buku, 'judul_buku' => $data->judul_buku, 'qtyjual' => $data->jualqtyhigh->qtyjual);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['qtyjual'] <=> $a['qtyjual'];
            });
            return view('Admin.JualBuku.analisa', compact(['kode', 'arrBuku']));
        }elseif($request->kode_analisa == 1){
            $indukbuku = IndukBuku::with(['jualnilaihigh'])->get();
            foreach($indukbuku as $data){
                if($data->jualnilaihigh != NULL){
                    $arrBuku[] = array('kode_buku' => $data->kode_buku, 'judul_buku' => $data->judul_buku, 'nilaijual' => $data->jualnilaihigh->nilaijual);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['nilaijual'] <=> $a['nilaijual'];
            });
            return view('Admin.JualBuku.analisa', compact(['kode', 'arrBuku']));
        }elseif($request->kode_analisa == 2){
            $indukbuku = Pelanggan::with(['jualbuku'])->get();
            foreach($indukbuku as $data){
                if($data->jualbuku != NULL){
                    $arrBuku[] = array('id_pelanggan' => $data->id_pelanggan, 'nm_pelanggan' => $data->nama, 'qtyjual' => $data->jualbuku->qtyjual, 'nilaijual' => $data->jualbuku->harga_total);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['nilaijual'] <=> $a['nilaijual'];
            });
            return view('Admin.JualBuku.analisa', compact(['kode', 'arrBuku']));
        }elseif($request->kode_analisa == 3){
            $indukbuku = Salesman::with(['jualbuku'])->get();
            foreach($indukbuku as $data){
                if($data->jualbuku != NULL){
                    $arrBuku[] = array('id_salesman' => $data->id_salesman, 'nm_salesman' => $data->nama, 'qtyjual' => $data->jualbuku->qtyjual, 'nilaijual' => $data->jualbuku->harga_total);
                }
            }
            usort($arrBuku, function($a, $b) {
                return $b['nilaijual'] <=> $a['nilaijual'];
            });
            return view('Admin.JualBuku.analisa', compact(['kode', 'arrBuku']));
        }
    }
}
