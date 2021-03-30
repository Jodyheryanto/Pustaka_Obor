<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\IndukBuku;
use App\Models\BeliBuku;
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

class AdminIndukBukuController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

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
                'persen_royalti' => $request->persen_royalti_pengarang,
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
        if ($files = $request->file('photo')) {
            
            //store file into document folder
            $file = $request->photo->store('public');
            $file_name = str_replace('public/', '', $file);
            // $url_image = $this->url->to('/storage') . '/' . $file_name;
            $url_image = $this->url->to('/laravel/storage/app/public') . '/' . $file_name;
            // insert data ke table books
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
                'harga_jual' => $request->harga_jual,
                'is_obral' => $request->status_jual,
                'berat' => $request->berat_buku,
                'cover' => $file_name,
                'link_cover' => $url_image,
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
        if ($files = $request->file('photo')) {
            //store file into document folder
            $file = $request->photo->store('public');
            $file_name = str_replace('public/', '', $file);
            // $url_image = $this->url->to('/storage') . '/' . $file_name;
            $url_image = $this->url->to('/laravel/storage/app/public') . '/' . $file_name;

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
            $indukbuku->harga_jual = $request->harga_jual;
            $indukbuku->is_obral = $request->status_jual;
            $indukbuku->berat = $request->berat_buku;
            $indukbuku->link_cover = $url_image;
            $indukbuku->cover = $file_name;
            $indukbuku->save();

            $stok = Stok::find($request->kode_buku);
            $stok->tb_lokasi_id = $request->id_lokasi;
            $stok->save();
            Alert::success('Success', 'Data berhasil diubah');
            return redirect()->route('admin.inventori.induk-buku.list');
        }else{
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
            $indukbuku->harga_jual = $request->harga_jual;
            $indukbuku->is_obral = $request->status_jual;
            $indukbuku->berat = $request->berat_buku;
            $indukbuku->save();

            $stok = Stok::find($request->kode_buku);
            $stok->tb_lokasi_id = $request->id_lokasi;
            $stok->save();
            Alert::success('Success', 'Data berhasil diubah');
            return redirect()->route('admin.inventori.induk-buku.list');
        }
    }

    function delete(Request $request){
        $indukbuku = IndukBuku::where('kode_buku',$request->kode_buku)->delete();
        
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.inventori.induk-buku.list');
    }

    function list(){
        if (Auth::user()->role !== 3 || Auth::user()->role !== 4)
		{
			$indukbuku = IndukBuku::with(['kategori', 'distributor', 'penerjemah', 'penerbit', 'pengarang', 'stock'])->get();
            return view('Admin.IndukBuku.list', compact(['indukbuku']));
		}
		else
		{
			abort(401);
		}
    }

    public function getInfo($id)
    {
        $fill = IndukBuku::with(['kategori', 'distributor', 'penerjemah', 'penerbit', 'pengarang', 'stock'])->where('kode_buku', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
