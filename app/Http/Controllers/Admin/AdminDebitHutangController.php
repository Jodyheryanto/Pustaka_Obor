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
use App\Models\BeliBuku;
use App\Models\FakturBeli;
use App\Models\KasKeluar;
use App\Models\JualBuku;
use App\Models\City;
use App\Models\Country;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Distributor;
use App\Models\Penerjemah;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Stok;
use App\Models\JurnalBeli;
use App\Models\Histori;
use App\Models\ReturBeli;
use App\Models\FakturReturBeli;
use App\Models\JurnalUmum;

class AdminDebitHutangController extends Controller
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
        $faktur = FakturBeli::with(['belibuku', 'jurnalbeli'])->where('id_faktur_pembelian', $id)->get();
        $fakturCount = count($faktur);
        $fakturone = FakturBeli::with(['belibuku'])->where('id_faktur_pembelian', $id)->first();
        return view('Admin.DebitHutang.bayar', compact(['faktur', 'fakturone', 'fakturCount']));
        // $jurnalbeli = JurnalBeli::with(['fakturbeli'])->where('kode_jurnal_pembelian', $id)->first();
        // return view('Admin.DebitHutang.bayar', compact(['jurnalbeli']));
    }

    public function bayar(Request $request)
	{
        date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
        $valid = 0;
        for($i=0; $i<$request->fakturCount; $i++){
            // var_dump($request->input('id_jurnal')[$i]);
            // var_dump($request->input('harga_bayar')[$i]);die;
            if($request->input('harga_bayar')[$i] != 0){
                KasKeluar::insert([
                    'tb_jurnal_pembelian_kode' => $request->input('id_jurnal')[$i],
                    'tgl_transaksi' => $now->format('Y-m-d H:i:s'),
                    'note' => "pelunasan",
                    'kredit_kas_keluar' => $request->input('debit_hutang')[$i],
                    'debit_hutang' => $request->input('harga_bayar')[$i],
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at' => $now->format('Y-m-d H:i:s')
                ]);
                if($request->denda != 0 && $valid == 0){
                    JurnalUmum::insert([
                        'tb_pembelian_buku_id' => $request->input('id_pembelian_buku')[$i],
                        'tgl_transaksi_retur' => $now->format('Y-m-d H:i:s'),
                        'debit_kredit_denda' => $request->denda,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                    $valid = 1;
                }
            }else{
                $stok = Stok::find($request->input('kode_buku')[$i]);
                $databeli = BeliBuku::where('id_pembelian_buku', $request->input('id_pembelian_buku')[$i])->first();
                if($stok->qty >= $request->qty_retur){
                    $harga_total = 0;
                    $harga_total = $request->input('qty')[$i]*$databeli->harga_beli_satuan;
                    ReturBeli::insert([
                        'tb_pembelian_buku_id' => $request->input('id_pembelian_buku')[$i],
                        'qty' => $request->input('qty')[$i],
                        'discount' => 0,
                        'note' => "Retur Utang",
                        'status_retur_pembelian' => 0,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at' => $now->format('Y-m-d H:i:s')
                    ]);
                    $data = ReturBeli::select('id_retur_pembelian')->orderBy('id_retur_pembelian', 'desc')->first();
                    $id_retur_pembelian = $data->id_retur_pembelian;
                    $belibuku = BeliBuku::with(['supplier'])->where('id_pembelian_buku', $request->input('id_pembelian_buku')[$i])->first();
                    Histori::insert([
                        'tb_induk_buku_kode_buku' => $request->input('kode_buku')[$i],
                        'id_transaksi' => 'RB' . $id_retur_pembelian,
                        'entitas' => $belibuku->supplier->nm_supplier,
                        'qty' => $request->input('qty')[$i],
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
                        if(date('Y-m-d', strtotime($data->updated_at)) === date('Y-m-d') && $valid === 0 && $belibuku->supplier->id_supplier == $data->belibuku->tb_supplier_id){
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
                }
            }
            $faktur = FakturBeli::find($request->input('id_faktur')[$i]);
            $faktur->status_bayar = 1;
            $faktur->updated_at = $now->format('Y-m-d H:i:s');
            $faktur->save();
        }
        
        // $jurnalbeli = JurnalBeli::find($request->kode_jurnal_pembelian);
        // $jurnalbeli->debit_pembelian = $request->debit_pembelian;
        // $jurnalbeli->updated_at = $now->format('Y-m-d H:i:s');
        // $jurnalbeli->save();
        
        Alert::success('Success', 'Pembayaran Berhasil Dilakukan');
        return redirect()->route('admin.hutang-piutang.debit-hutang.list');
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
        $jurnalbeli = JurnalBeli::with(['fakturbeli', 'kaskeluar'])
                    ->join('tb_faktur_pembelian','tb_faktur_pembelian.id','=','tb_jurnal_pembelian.tb_terima_bukti_id')
                    ->orderBy('tb_faktur_pembelian.id_faktur_pembelian', 'asc')
                    ->get();
        return view('Admin.DebitHutang.list', compact(['jurnalbeli']));
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
            return redirect()->route('admin.buku-besar.pembelian.lapor-pembelian');
        }elseif($request->transaksi == 1){
            return redirect()->route('admin.buku-besar.pembelian.lapor-hutang');
        }else{
            return redirect()->route('admin.buku-besar.pembelian.lapor-retur-pembelian');
        }
    }

    function hutang(Request $request){
        $jurnalbeli = JurnalBeli::select('kredit_hutang', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $jurnalumum = JurnalUmum::where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $kaskeluar = KasKeluar::select('debit_hutang', 'tgl_transaksi')->whereNotNull('tb_jurnal_pembelian_kode')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangKredit = array();
        $piutangDebit = array();

        foreach($jurnalbeli as $data){
            if($data->kredit_hutang != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_hutang, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($jurnalumum as $data){
            if($data->tb_retur_pembelian_id != NULL){
                if($data->debit_hutang != NULL && $data->returbeli->belibuku->status_pembelian == 1 && $data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar != NULL){
                    if($data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar->created_at > $data->created_at){
                        $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur);
                    }
                }elseif($data->debit_hutang != NULL && $data->returbeli->belibuku->status_pembelian == 1 && $data->returbeli->belibuku->fakturbeli->jurnalbeli->kaskeluar == NULL){
                    $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur);
                }
            }elseif($data->tb_pembelian_buku_id != NULL && $data->debit_kredit_denda != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
                $piutangKredit[] = array('nominal' => $data->debit_kredit_denda, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        // foreach($jurnalumum as $data){
        //     if($data->debit_hutang != NULL){
        //         $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi_retur);
        //     }
        // }
        foreach($kaskeluar as $data){
            if($data->debit_hutang != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_hutang, 'tanggal' => $data->tgl_transaksi);
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

        return view('Admin.DebitHutang.hutang', compact(['piutangDebit', 'piutangKredit', 'max']));
    }

    function pembelian(Request $request){
        $jurnalbeli = JurnalBeli::select('debit_pembelian', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $kaskeluar = KasKeluar::select('debit_pembelian', 'tgl_transaksi')->where('tgl_transaksi', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangDebit = array();

        foreach($jurnalbeli as $data){
            if($data->debit_pembelian != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_pembelian, 'tanggal' => $data->tgl_transaksi);
            }
        }
        foreach($kaskeluar as $data){
            if($data->debit_pembelian != NULL){
                $piutangDebit[] = array('nominal' => $data->debit_pembelian, 'tanggal' => $data->tgl_transaksi);
            }
        }
        usort($piutangDebit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangDebit);
        
        return view('Admin.DebitHutang.pembelian', compact(['piutangDebit', 'max']));
    }

    function retur_pembelian(Request $request){
        $jurnalumum = JurnalUmum::select('kredit_retur_pembelian', 'tgl_transaksi_retur')->where('tgl_transaksi_retur', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))))->where('tgl_transaksi_retur', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai'))))->get();
        $piutangKredit = array();

        foreach($jurnalumum as $data){
            if($data->kredit_retur_pembelian != NULL){
                $piutangKredit[] = array('nominal' => $data->kredit_retur_pembelian, 'tanggal' => $data->tgl_transaksi_retur);
            }
        }
        usort($piutangKredit, function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        $max = count($piutangKredit);
        
        return view('Admin.DebitHutang.retur_pembelian', compact(['piutangKredit', 'max']));
    }
}
