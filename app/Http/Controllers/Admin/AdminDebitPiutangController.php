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
use App\Models\JualBuku;
use App\Models\FakturJual;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\City;
use App\Models\Country;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Distributor;
use App\Models\Penerjemah;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Stok;
use App\Models\JurnalJual;
use App\Models\JurnalUmum;
use App\Models\ReturJual;
use App\Models\FakturReturJual;
use App\Models\Histori;
use App\Models\KasLain2;

class AdminDebitPiutangController extends Controller
{
    function showCreateForm(){
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $penerjemah = Penerjemah::all();
        $distributor = Distributor::all();
        $pengarang = Pengarang::all();
        $lokasi = Lokasi::all();
        $cities = City::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        return view('Admin.IndukBuku.create', compact(['countries', 'cities', 'kategori', 'penerbit', 'penerjemah', 'distributor', 'pengarang', 'lokasi']));
    }

    public function create(Request $request)
	{
        $id_pengarang = $request->id_pengarang;
        $id_distributor = $request->id_distributor;
        $id_penerbit = $request->id_penerbit;
        $id_penerjemah = $request->id_penerjemah;
        // insert data ke table books
        $valid_kode_buku = IndukBuku::where('kode_buku', $request->kode_buku)->first();
        if($valid_kode_buku !== NULL){
            $kode_buku = $request->kode_buku . '1';
        }else{
            $kode_buku = $request->kode_buku;
        }
        if($request->id_pengarang === NULL){
            Pengarang::insert([
                'NPWP' => $request->NPWP_pengarang,
                'NIK' => $request->NIK_pengarang,
                'nm_pengarang' => $request->nm_pengarang,
                'email' => $request->email_pengarang,
                'telepon' => $request->telepon_pengarang,
                'tb_negara_id' => $request->negara_pengarang,
                'tb_kota_id' => $request->kota_pengarang,
                'tb_kecamatan_id' => $request->kecamatan_pengarang,
                'tb_kelurahan_id' => $request->kelurahan_pengarang,
                'kode_pos' => $request->kode_pos_pengarang,
                'alamat' => $request->alamat_pengarang,
                'nama_rekening' => $request->nama_rek_pengarang,
                'bank_rekening' => $request->bank_rek_pengarang,
                'nomor_rekening' => $request->no_rek_pengarang,
            ]);
            $data = Pengarang::select('id_pengarang')->orderBy('id_pengarang', 'desc')->first();
            $id_pengarang = $data->id_pengarang;
        }
        if($request->id_distributor === NULL){
            Distributor::insert([
                'NPWP' => $request->NPWP_distributor,
                'nm_distributor' => $request->nm_distributor,
                'email' => $request->email_distributor,
                'telepon' => $request->telepon_distributor,
                'tb_kota_id' => $request->kota_distributor,
                'tb_kecamatan_id' => $request->kecamatan_distributor,
                'tb_kelurahan_id' => $request->kelurahan_distributor,
                'kode_pos' => $request->kode_pos_distributor,
                'alamat' => $request->alamat_distributor
            ]);
            $data = Distributor::select('id_distributor')->orderBy('id_distributor', 'desc')->first();
            $id_distributor = $data->id_distributor;
        }
        if($request->id_penerbit === NULL){
            Penerbit::insert([
                'NPWP' => $request->NPWP_penerbit,
                'nm_penerbit' => $request->nm_penerbit,
                'email' => $request->email_penerbit,
                'telepon' => $request->telepon_penerbit,
                'tb_kota_id' => $request->kota_penerbit,
                'tb_kecamatan_id' => $request->kecamatan_penerbit,
                'tb_kelurahan_id' => $request->kelurahan_penerbit,
                'kode_pos' => $request->kode_pos_penerbit,
                'alamat' => $request->alamat_penerbit
            ]);
            $data = Penerbit::select('id_penerbit')->orderBy('id_penerbit', 'desc')->first();
            $id_penerbit = $data->id_penerbit;
        }
        if($request->id_penerjemah === NULL && $request->nm_penerjemah !== NULL){
            Penerjemah::insert([
                'NPWP' => $request->NPWP_penerjemah,
                'nm_penerjemah' => $request->nm_penerjemah,
                'email' => $request->email_penerjemah,
                'telepon' => $request->telepon_penerjemah,
                'tb_kota_id' => $request->kota_penerjemah,
                'tb_kecamatan_id' => $request->kecamatan_penerjemah,
                'tb_kelurahan_id' => $request->kelurahan_penerjemah,
                'kode_pos' => $request->kode_pos_penerjemah,
                'alamat' => $request->alamat_penerjemah
            ]);
            $data = Penerjemah::select('id_penerjemah')->orderBy('id_penerjemah', 'desc')->first();
            $id_penerjemah = $data->id_penerjemah;
        }
        IndukBuku::insert([
            'kode_buku' => $kode_buku,
            'isbn' => $request->isbn,
            'judul_buku' => $request->judul_buku,
            'tb_pengarang_id' => $id_pengarang,
            'tb_penerbit_id' => $id_penerbit,
            'tb_kategori_id' => $request->id_kategori,
            'tb_distributor_id' => $id_distributor,
            'tb_penerjemah_id' => $id_penerjemah,
            'deskripsi_buku' => $request->deskripsi_buku,
            'tahun_terbit' => $request->tahun_terbit
        ]);
        Stok::insert([
            'tb_induk_buku_kode_buku' => $kode_buku,
            'tb_lokasi_id' => $request->id_lokasi,
            'qty' => $request->qty
        ]);
        // alihkan halaman tambah buku ke halaman books
        if($request->status == 0){
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->route('admin.inventori.induk-buku.list');
        }else{
            Alert::warning('Pemberitahuan', 'Apabila ini benar barang titip, harap segera daftarkan ke faktur konsinyasi');
            return redirect()->route('admin.faktur.konsinyasi.showCreateForm');
        }
    }

    function showBayarForm($id){
        // $jurnaljual = JurnalJual::with(['fakturjual'])->where('kode_jurnal_penjualan', $id)->first();
        $faktur = FakturJual::with(['jualbuku', 'jurnaljual'])->where('id_faktur_penjualan', $id)->get();
        $ongkir = KasLain2::where('id_faktur', $id)->first();
        if($ongkir != NULL){
            $ongkir = $ongkir->kredit;
        }else{
            $ongkir = 0;
        }
        $fakturCount = count($faktur);
        $fakturone = FakturJual::with(['jualbuku'])->where('id_faktur_penjualan', $id)->first();
        return view('Admin.DebitPiutang.bayar', compact(['faktur', 'fakturone', 'fakturCount', 'ongkir']));
        // return view('Admin.DebitPiutang.bayar', compact(['jurnaljual']));
    }

    public function bayar(Request $request)
	{
        $valid = 0;
        $id_faktur = NULL;
        for($i=0; $i<$request->fakturCount; $i++){
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            // var_dump($request->input('id_jurnal')[$i]);
            // var_dump($request->input('harga_bayar')[$i]);die;
            $indukbuku = IndukBuku::with(['pengarang'])->where('kode_buku', $request->input('kode_buku')[$i])->first();
            $royalti = ($request->input('total_non_diskon')[$i] * $indukbuku->pengarang->persen_royalti) / 100;
            $total_retur = ($request->input('total_retur')[$i] * $indukbuku->pengarang->persen_royalti) / 100;
            if($request->input('harga_bayar')[$i] != 0){
                JurnalUmum::insert([
                    'tb_penjualan_buku_id' => $request->input('id_penjualan_buku')[$i],
                    'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                    'debit_kredit_royalti' => $royalti - $total_retur,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
                KasMasuk::insert([
                    'tb_jurnal_penjualan_kode' => $request->input('id_jurnal')[$i],
                    'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                    'note' => "Pelunasan",
                    'debit_kas_masuk' => $request->input('kredit_piutang')[$i],
                    'kredit_piutang' => $request->input('harga_bayar')[$i],
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
            }else{
                $datajual = JualBuku::where('id_penjualan_buku', $request->input('id_penjualan_buku')[$i])->first();
                $stok = Stok::find($request->input('kode_buku')[$i]);
                if($stok->qty >= $request->input('qty')[$i]){
                    date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
                    if($datajual->discount !== NULL){
                        $harga_diskon = ($datajual->discount * ($request->input('qty')[$i]*$datajual->harga_jual_satuan)) / 100;
                        $harga_total = ($request->input('qty')[$i]*$datajual->harga_jual_satuan) - $harga_diskon;
                        $diskon = $datajual->discount;
                    }else{
                        $harga_total = $request->input('qty')[$i]*$datajual->harga_jual_satuan;
                        $diskon = 0;
                    }
                    ReturJual::insert([
                        'tb_penjualan_buku_id' => $request->input('id_penjualan_buku')[$i],
                        'qty' => $request->input('qty')[$i],
                        'discount' => $diskon,
                        'harga_satuan' => $datajual->harga_jual_satuan,
                        'total_harga' => $harga_total,
                        'total_non_diskon' => $request->input('qty')[$i]*$datajual->harga_jual_satuan,
                        'note' => 'Retur Utang',
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                        // 'qty' => $request->qty_retur,
                        // 'status_retur_penjualan' => $request->status_retur_penjualan,
                        // 'bukti_retur_penjualan' => $request->bukti_retur_penjualan
                    ]);
                    $data = ReturJual::select('id_retur_penjualan')->orderBy('id_retur_penjualan', 'desc')->first();
                    $id_retur_penjualan = $data->id_retur_penjualan;
                    $jualbuku = JualBuku::with(['pelanggan'])->where('id_penjualan_buku', $request->input('id_penjualan_buku')[$i])->first();
                    Histori::insert([
                        'tb_induk_buku_kode_buku' => $request->input('kode_buku')[$i],
                        'id_transaksi' => 'RJ' . $id_retur_penjualan,
                        'entitas' => $jualbuku->pelanggan->nama,
                        'qty' => $request->input('qty')[$i],
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
                        if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0 && $jualbuku->pelanggan->id_pelanggan == $data->jualbuku->tb_pelanggan_id){
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
                    $stok->qty =  $stok->qty + $request->input('qty')[$i];
                    $stok->save();
                }
            }
            $faktur = FakturJual::find($request->input('id_faktur')[$i]);
            $faktur->status_bayar = 1;
            $faktur->updated_at = $now->format('Y-m-d H:i:s');
            $faktur->save();
            // KasKeluar::insert([
            //     'tb_penjualan_buku_id' => $request->input('id_penjualan_buku')[$i],
            //     'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
            //     'note' => "Royalti",
            //     'kredit_kas_keluar' => $royalti,
            //     'created_at' => $now->format('Y-m-d H:i:s'),
            //     'updated_at' => $now->format('Y-m-d H:i:s')
            // ]);
            if($request->denda != 0 && $valid == 0){
                JurnalUmum::insert([
                    'tb_penjualan_buku_id' => $request->input('id_penjualan_buku')[$i],
                    'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                    'debit_kredit_denda' => $request->denda,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
                $valid = 1;
            }
            $id_faktur = $request->input('id_faktur')[$i];
        }
        $fakturone = FakturJual::where('id', $id_faktur)->first();
        $ongkir = KasLain2::where('id_faktur', $fakturone->id_faktur_penjualan)->first();
        if($ongkir != NULL){
            if($ongkir->tb_data_account_id != 'NB'){
                KasLain2::insert([
                    'tb_data_account_id' => $ongkir->tb_data_account_id,
                    'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                    'debit' => $ongkir->kredit,
                    'kredit' => 0,
                    'note' => $ongkir->note,
                    'id_faktur' => $fakturone->id_faktur_penjualan,
                    'is_bayar' => 1
                ]);
            }
        }
        Alert::success('Success', 'Pembayaran Berhasil Dilakukan');
        return redirect()->route('admin.hutang-piutang.debit-piutang.list');
    }
    
    function showEditForm($id){
        $indukbuku = IndukBuku::where('kode_buku', $id)->first();
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $penerjemah = Penerjemah::all();
        $distributor = Distributor::all();
        $pengarang = Pengarang::all();
        $lokasi = Lokasi::all();
        $stok = Stok::where('tb_induk_buku_kode_buku', $id)->first();
        return view('Admin.IndukBuku.edit', compact(['indukbuku', 'kategori', 'penerbit', 'penerjemah', 'distributor', 'pengarang', 'lokasi', 'stok']));
    }

    public function update(Request $request)
	{
        $indukbuku = IndukBuku::find($request->kode_buku);
        $indukbuku->isbn = $request->isbn;
        $indukbuku->judul_buku = $request->judul_buku;
        $indukbuku->tb_pengarang_id = $request->id_pengarang;
        $indukbuku->tb_penerbit_id = $request->id_penerbit;
        $indukbuku->tb_kategori_id = $request->id_kategori;
        $indukbuku->tb_distributor_id = $request->id_distributor;
        $indukbuku->tb_penerjemah_id = $request->id_penerjemah;
        $indukbuku->deskripsi_buku = $request->deskripsi_buku;
        $indukbuku->tahun_terbit = $request->tahun_terbit;
        $indukbuku->save();

        $stok = Stok::find($request->kode_buku);
        $stok->qty =  $request->qty;
        $stok->tb_lokasi_id = $request->id_lokasi;
        $stok->save();
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.inventori.induk-buku.list');
    }

    function delete(Request $request){
        $indukbuku = IndukBuku::where('kode_buku',$request->kode_buku)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.inventori.induk-buku.list');
    }

    function list(){
        $jurnaljual = JurnalJual::with(['fakturjual', 'kasmasuk'])
                    ->join('tb_faktur_penjualan','tb_faktur_penjualan.id','=','tb_jurnal_penjualan.tb_faktur_penjualan_id')
                    ->orderBy('tb_faktur_penjualan.id_faktur_penjualan', 'asc')
                    ->get();
        return view('Admin.DebitPiutang.list', compact(['jurnaljual']));
    }

    public function getInfo($id)
    {
        $fill = IndukBuku::with(['kategori', 'distributor', 'penerjemah', 'penerbit', 'pengarang', 'stock'])->where('kode_buku', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }

    public function filter(Request $request)
    {
        $request->session()->put('tgl_mulai', $request->tgl_mulai);
        $request->session()->put('tgl_selesai', $request->tgl_selesai);
        if($request->transaksi == 0){
            return redirect()->route('admin.buku-besar.penjualan.lapor-penjualan');
        }elseif($request->transaksi == 1){
            return redirect()->route('admin.buku-besar.penjualan.lapor-piutang');
        }elseif($request->transaksi == 2){
            return redirect()->route('admin.buku-besar.penjualan.lapor-retur-penjualan');
        }else{
            return redirect()->route('admin.buku-besar.penjualan.lapor-royalti');
        }
    }

    function piutang(Request $request){
        $jurnaljual = JurnalJual::select('debit_piutang', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $jurnalumum = JurnalUmum::where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $kasmasuk = KasMasuk::select('kredit_piutang', 'tgl_transaksi')->whereNotNull('tb_jurnal_penjualan_kode')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangKredit = array();
        $piutangDebit = array();

        foreach($jurnaljual as $data){
            if($data->debit_piutang != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_piutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($jurnalumum as $data){
            if($data->tb_retur_penjualan_id != NULL){
                if($data->kredit_piutang != NULL && $data->returjual->jualbuku->status_penjualan == 1 && $data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk != NULL){
                    if($data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk->created_at > $data->created_at){
                        $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi_retur);
                    }
                }elseif($data->kredit_piutang != NULL && $data->returjual->jualbuku->status_penjualan == 1 && $data->returjual->jualbuku->fakturjual->jurnaljual->kasmasuk == NULL){
                    $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi_retur);
                }
            }elseif($data->tb_penjualan_buku_id != NULL && $data->debit_kredit_denda != NULL){
                $piutangKredit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
                $piutangDebit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        foreach($kasmasuk as $data){
            if($data->kredit_piutang != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_piutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        if(count($piutangDebit) >= count($piutangKredit)){
            $max = count($piutangDebit);
        }else{
            $max = count($piutangKredit);
        }

        return view('Admin.DebitPiutang.piutang', compact(['piutangDebit', 'piutangKredit', 'max']));
    }

    function royalti(Request $request){
        $jurnalumum = JurnalUmum::whereNotNull('tb_penjualan_buku_id')->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangKredit = array();
        $piutangDebit = array();

        foreach($jurnalumum as $data){
            if($data->debit_kredit_royalti != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_kredit_royalti, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }

        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);

        return view('Admin.DebitPiutang.royalti', compact(['piutangDebit', 'max']));
    }

    function penjualan(Request $request){
        $jurnaljual = JurnalJual::select('kredit_penjualan', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $kasmasuk = KasMasuk::select('kredit_penjualan', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangKredit = array();

        foreach($jurnaljual as $data){
            if($data->kredit_penjualan != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_penjualan, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($kasmasuk as $data){
            if($data->kredit_penjualan != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_penjualan, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangKredit);
        
        return view('Admin.DebitPiutang.penjualan', compact(['piutangKredit', 'max']));
    }

    function retur_penjualan(Request $request){
        $jurnalumum = JurnalUmum::select('debit_retur_penjualan', 'tgl_transaksi_retur')->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangDebit = array();

        foreach($jurnalumum as $data){
            if($data->debit_retur_penjualan != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_retur_penjualan, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);
        
        return view('Admin.DebitPiutang.retur_penjualan', compact(['piutangDebit', 'max']));
    }
}
