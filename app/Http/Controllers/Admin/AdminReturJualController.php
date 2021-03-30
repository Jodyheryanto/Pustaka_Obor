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
use App\Models\JualBuku;
use App\Models\ReturJual;
use App\Models\Stok;
use App\Models\Histori;
use App\Models\FakturReturJual;
use App\Models\JurnalUmum;
use App\Models\IndukBuku;
use App\Models\KasMasuk;

class AdminReturJualController extends Controller
{
    function showCreateForm(){
        $jualbuku = JualBuku::with(['indukbuku'])->get();
        return view('Admin.ReturJual.create', compact(['jualbuku']));
    }

    public function create(Request $request)
	{
        $stok = Stok::find($request->kode_buku);
        if($stok->qty >= $request->qty){
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            if($request->diskon_retur !== NULL){
                $harga_diskon = ($request->diskon_retur * ($request->qty_retur*$request->harga_retur_satuan)) / 100;
                $harga_total = ($request->qty_retur*$request->harga_retur_satuan) - $harga_diskon;
                $diskon = $request->diskon_retur;
            }else{
                $harga_total = $request->qty_retur*$request->harga_retur_satuan;
                $diskon = 0;
            }
            ReturJual::insert([
                'tb_penjualan_buku_id' => $request->id_penjualan_buku,
                'qty' => $request->qty_retur,
                'discount' => $diskon,
                'harga_satuan' => $request->harga_retur_satuan,
                'total_harga' => $harga_total,
                'total_non_diskon' => $request->qty_retur*$request->harga_retur_satuan,
                'note' => $request->note_retur,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
                // 'qty' => $request->qty_retur,
                // 'status_retur_penjualan' => $request->status_retur_penjualan,
                // 'bukti_retur_penjualan' => $request->bukti_retur_penjualan
            ]);
            $data = ReturJual::select('id_retur_penjualan')->orderBy('id_retur_penjualan', 'desc')->first();
            $id_retur_penjualan = $data->id_retur_penjualan;
            $jualbuku = JualBuku::with(['pelanggan'])->where('id_penjualan_buku', $request->id_penjualan_buku)->first();
            Histori::insert([
                'tb_induk_buku_kode_buku' => $request->kode_buku,
                'id_transaksi' => 'RJ' . $id_retur_penjualan,
                'entitas' => $jualbuku->pelanggan->nama,
                'qty' => $request->qty_retur,
                'status' => 0,
                'discount' => $diskon,
                'harga_satuan' => $jualbuku->harga_jual_satuan,
                'harga_total' => $harga_total,
                'stok_awal' => $stok->qty,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            $returjual = ReturJual::with(['jualbuku'])->get();
            $valid = 0;
            foreach($returjual as $data){
            // var_dump(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0 && $request->id_pelanggan == $data->jualbuku->tb_pelanggan_id);die;
                if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0 && $request->id_pelanggan == $data->jualbuku->tb_pelanggan_id){
                    $faktur = FakturReturJual::where('tb_retur_penjualan_id', $data->id_retur_penjualan)->first();
                    if($faktur !== NULL){
                        FakturReturJual::insert([
                            'id_faktur_retur_penjualan' => $faktur->id_faktur_retur_penjualan,
                            'tb_retur_penjualan_id' => $id_retur_penjualan
                        ]);
                    }else{
                        $fakturterakhir = FakturReturJual::select('id_faktur_retur_penjualan')->orderBy('id_faktur_retur_penjualan', 'desc')->first();
                        if($fakturterakhir === NULL){
                            FakturReturJual::insert([
                                'id_faktur_retur_penjualan' => 'FKTRJ1',
                                'tb_retur_penjualan_id' => $id_retur_penjualan
                            ]);
                        }else{
                            $id_faktur_retur_penjualan = $fakturterakhir->id_faktur_retur_penjualan;
                            $split = preg_split('#(?<=[a-z])(?=\d)#i', $id_faktur_retur_penjualan);
                            $id_faktur_retur_penjualan = (int) $split[1] + 1;
                            $id_faktur_retur_penjualan = 'FKTRJ' . $id_faktur_retur_penjualan;
                            FakturReturJual::insert([
                                'id_faktur_retur_penjualan' => $id_faktur_retur_penjualan,
                                'tb_retur_penjualan_id' => $id_retur_penjualan
                            ]);
                        }
                    }
                    $valid = 1;
                }
            }
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            JurnalUmum::insert([
                'tb_retur_penjualan_id' => $id_retur_penjualan,
                'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                'kredit_piutang' => $harga_total,
                'debit_retur_penjualan' => $harga_total,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ]);
            // if($jualbuku->status_penjualan == 0){
            //     KasMasuk::insert([
            //         'tb_retur_penjualan_id' => $id_retur_penjualan,
            //         'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
            //         'note' => "Royalti Dikembalikan",
            //         'debit_kas_masuk' => (($request->qty_retur*$request->harga_retur_satuan) * 10) / 100,
            //         'created_at' => $now->format('Y-m-d H:i:s'),
            //         'updated_at' => $now->format('Y-m-d H:i:s')
            //     ]);
            // }
            $stok->qty =  $stok->qty + $request->qty_retur;
            $stok->save();

            $royalti = JurnalUmum::where('tb_penjualan_buku_id', $request->id_penjualan_buku)->first();
            $indukbuku = IndukBuku::with(['pengarang'])->where('kode_buku', $request->kode_buku)->first();
            if(!empty($royalti) > 0){
                $royalti->debit_kredit_royalti =  $royalti->debit_kredit_royalti - ((($request->qty_retur*$request->harga_retur_satuan) * $indukbuku->pengarang->persen_royalti) / 100);
                $royalti->save();
            }
            // alihkan halaman tambah buku ke halaman books
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->route('admin.inventori.retur-penjualan.list');
        }else{
            // alihkan halaman tambah buku ke halaman books
            Alert::error('Gagal', 'Kondisi Khusus. Error karena qty pada stok tidak cukup');
            return redirect()->route('admin.inventori.retur-pembelian.list');
        }
    }
    
    function showEditForm($id){
        $returjual = ReturJual::with(['jualbuku'])->where('id_retur_penjualan', $id)->first();
        $jualbuku = JualBuku::with(['indukbuku'])->get();
        return view('Admin.ReturJual.edit', compact(['returjual', 'jualbuku']));
    }

    public function update(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        if($request->diskon_retur !== NULL){
            $harga_diskon = ($request->diskon_retur * ($request->qty_retur*$request->harga_retur_satuan)) / 100;
            $harga_total = ($request->qty_retur*$request->harga_retur_satuan) - $harga_diskon;
            $diskon = $request->diskon_retur;
        }else{
            $harga_total = $request->qty_retur*$request->harga_retur_satuan;
            $diskon = 0;
        }
        $returjual = ReturJual::find($request->id_retur_penjualan);
        $tempqty = $returjual->qty;
        
        if($request->kode_buku == $request->kode_buku_sblm){
            $returjual->tb_penjualan_buku_id =  $request->id_penjualan_buku;
            $returjual->qty = $request->qty_retur;
            $returjual->discount = $diskon;
            $returjual->harga_satuan = $request->harga_retur_satuan;
            $returjual->total_harga = $harga_total;
            $returjual->note = $request->note_retur;
            $returjual->save();

            $stok = Stok::find($request->kode_buku);
            if($tempqty > $request->qty){
                $stok->qty =  $stok->qty - ($tempqty - $request->qty_retur);
            }else{
                $stok->qty =  $stok->qty + ($request->qty_retur - $tempqty);
            }
            $stok->save();
        }else{
            $stok = Stok::find($request->kode_buku_sblm);
            $stok->qty =  $stok->qty - $tempqty;

            $returjual->tb_penjualan_buku_id =  $request->id_penjualan_buku;
            $returjual->qty = $request->qty_retur;
            $returjual->discount = $diskon;
            $returjual->harga_satuan = $request->harga_retur_satuan;
            $returjual->total_harga = $harga_total;
            $returjual->note = $request->note_retur;
            $returjual->updated_at = $now->format('Y-m-d H:i:s');
            $returjual->save();

            $stok = Stok::find($request->kode_buku);
            $stok->qty =  $stok->qty + $request->qty_retur;
            $stok->save();
        }
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.inventori.retur-penjualan.list');
    }

    function delete(Request $request){
        $histori = Histori::where('id_transaksi','RJ'.$request->id_retur_penjualan)->first();
        $histori->status =  1;
        $histori->save();
        $royalti = JurnalUmum::where('tb_penjualan_buku_id', $request->id_penjualan_buku)->first();
        $returjual = ReturJual::where('id_retur_penjualan',$request->id_retur_penjualan)->first();
        $indukbuku = IndukBuku::with(['pengarang'])->where('kode_buku', $request->kode_buku)->first();
        if(!empty($royalti) > 0){
            $royalti->debit_kredit_royalti =  $royalti->debit_kredit_royalti + ((($returjual->total_non_diskon) * $indukbuku->pengarang->persen_royalti) / 100);
            $royalti->save();
        }
        $stok = Stok::find($request->kode_buku);
        $stok->qty =  $stok->qty - $request->qty_retur;
        $stok->save();
        $returjual = ReturJual::where('id_retur_penjualan',$request->id_retur_penjualan)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.inventori.retur-penjualan.list');
    }

    function list(){
        $fakturdb = FakturReturJual::with(['returjual'])->get();
        $myArray = array();
        $faktur = array();
        $i = -1;
        foreach($fakturdb as $data){
            $myArray[] = array('id_faktur' => $data->id_faktur_retur_penjualan, 'nama_pelanggan' => $data->returjual->jualbuku->pelanggan->nama, 'tgl_faktur' => $data->returjual->updated_at);
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
        $returjual = ReturJual::with(['jualbuku'])->get();
        return view('Admin.ReturJual.list', compact(['returjual', 'faktur']));
    }

    function cetak(Request $request){
        $faktur = FakturReturJual::with(['returjual'])->where('id_faktur_retur_penjualan', $request->id_faktur)->get();
        $fakturone = FakturReturJual::with(['returjual'])->where('id_faktur_retur_penjualan', $request->id_faktur)->first();
        return view('Admin.ReturJual.cetak', compact(['faktur', 'fakturone']));
    }
}
