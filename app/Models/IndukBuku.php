<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IndukBuku extends Model
{
    use HasFactory;
    protected $table = 'tb_induk_buku';
	protected $primaryKey = 'kode_buku';

    public $incrementing = false;
    protected $keyType = 'char';
	public $timestamps = true;

	public function kategori()
    {
        return $this->hasOne(Kategori::class, 'id_kategori', 'tb_kategori_id');
	}
	public function pengarang()
    {
        return $this->hasOne(Pengarang::class, 'id_pengarang', 'tb_pengarang_id');
	}
	public function penerbit()
    {
        return $this->hasOne(Penerbit::class, 'id_penerbit', 'tb_penerbit_id');
	}
	public function distributor()
    {
        return $this->hasOne(Distributor::class, 'id_distributor', 'tb_distributor_id');
	}
	public function penerjemah()
    {
        return $this->hasOne(Penerjemah::class, 'id_penerjemah', 'tb_penerjemah_id');
	}
	public function stock()
    {
        return $this->hasOne(Stok::class, 'tb_induk_buku_kode_buku', 'kode_buku');
    }

    public function histori()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasMany(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
            ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
            ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59")
            ->orderBy('created_at', 'asc');
    }

    public function sumjual()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyjual'))
                ->groupBy('tb_induk_buku_kode_buku')
                ->where('id_transaksi', 'like', 'J%')
                ->where('status', 0)
                ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
                ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
    }

    public function sumbeli()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtybeli'))
                ->groupBy('tb_induk_buku_kode_buku')
                ->where('status', 0)
                ->where('id_transaksi', 'like', 'B%')
                ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
                ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
    }

    public function sumtitip()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qty'))
                ->groupBy('tb_induk_buku_kode_buku')
                ->where('status', 0)
                ->where('id_transaksi', 'like', 'FKP%')
                ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
                ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
    }

    public function sumterima()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qty'))
                ->groupBy('tb_induk_buku_kode_buku')
                ->where('status', 0)
                ->where('id_transaksi', 'like', 'FKT%')
                ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
                ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
    }

    public function sumreturbeli()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyretur'))
                ->groupBy('tb_induk_buku_kode_buku')
                ->where('status', 0)
                ->where('id_transaksi', 'like', '%RB%')
                ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
                ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
    }

    public function sumreturjual()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(Histori::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyretur'))
                ->groupBy('tb_induk_buku_kode_buku')
                ->where('status', 0)
                ->where('id_transaksi', 'like', '%RJ%')
                ->where('created_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")
                ->where('created_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
    }

    public function sumjualbuku()
    {
        return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyjual'))
                ->groupBy('tb_induk_buku_kode_buku');
    }
    public function sumbelibuku()
    {
        return $this->hasOne(BeliBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtybeli'))
                ->groupBy('tb_induk_buku_kode_buku');
    }

    public function jualbuku()
    {
        return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select(DB::raw('sum(tb_penjualan_buku.qty) as qtyjual'), DB::raw('avg(tb_penjualan_buku.harga_jual_satuan) as harga_satuan'), DB::raw('sum(tb_penjualan_buku.total_non_diskon) as harga_total'), DB::raw('sum(tb_retur_penjualan.qty) as qtyretur'), DB::raw('avg(tb_retur_penjualan.harga_satuan) as harga_satuan_retur'), DB::raw('sum(tb_retur_penjualan.total_non_diskon) as harga_total_retur'))
                ->join('tb_retur_penjualan', 'tb_retur_penjualan.tb_penjualan_buku_id', '=', 'tb_penjualan_buku.id_penjualan_buku')
                ->groupBy('tb_penjualan_buku.tb_induk_buku_kode_buku')->where('tb_penjualan_buku.status_royalti', 0);
        // return $this->hasMany(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku');
    }

    public function jualbukuadmin()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select(DB::raw('sum(tb_penjualan_buku.qty) as qtyjual'), DB::raw('avg(tb_penjualan_buku.harga_jual_satuan) as harga_satuan'), DB::raw('sum(tb_penjualan_buku.total_non_diskon) as harga_total'), DB::raw('sum(tb_retur_penjualan.qty) as qtyretur'), DB::raw('avg(tb_retur_penjualan.harga_satuan) as harga_satuan_retur'), DB::raw('sum(tb_retur_penjualan.total_non_diskon) as harga_total_retur'))
                ->join('tb_retur_penjualan', 'tb_retur_penjualan.tb_penjualan_buku_id', '=', 'tb_penjualan_buku.id_penjualan_buku')
                ->where('tb_penjualan_buku.updated_at', '>=', date('Y-m-d', strtotime( $request->session()->get('tgl_mulai'))) . " 00:00:00")->where('tb_penjualan_buku.updated_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
        // return $this->hasMany(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku');
    }

    public function jualdetail()
    {
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasMany(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->where('tb_penjualan_buku.status_royalti', 0);
        // return $this->hasMany(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku');
    }

    public function konsinyasi()
    {
        return $this->hasMany(FakturKonsinyasi::class, 'tb_induk_buku_kode_buku', 'kode_buku');
    }
    // public function sumjualbuku()
    // {
    //     return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
    //             ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyjual'))
    //             ->groupBy('tb_induk_buku_kode_buku');
    // }
    // public function sumjualbuku()
    // {
    //     return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
    //             ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyjual'))
    //             ->groupBy('tb_induk_buku_kode_buku');
    // }
    public function jualqtyhigh(){
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtyjual'))
                ->groupBy('tb_induk_buku_kode_buku')->where('updated_at', '>=', $request->session()->get('tgl_mulai') . " 00:00:00")->where('updated_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");;
    }

    public function jualnilaihigh(){
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(JualBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(harga_total) as nilaijual'))
                ->groupBy('tb_induk_buku_kode_buku')->where('updated_at', '>=', $request->session()->get('tgl_mulai') . " 00:00:00")->where('updated_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");;
    }

    public function beliqtyhigh(){
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(BeliBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(qty) as qtybeli'))
                ->groupBy('tb_induk_buku_kode_buku')->where('updated_at', '>=', $request->session()->get('tgl_mulai') . " 00:00:00")->where('updated_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");;
    }

    public function belinilaihigh(){
        $request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(BeliBuku::class, 'tb_induk_buku_kode_buku', 'kode_buku')
                ->select('tb_induk_buku_kode_buku', DB::raw('sum(total_harga) as nilaibeli'))
                ->groupBy('tb_induk_buku_kode_buku')->where('updated_at', '>=', $request->session()->get('tgl_mulai') . " 00:00:00")->where('updated_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");;
    }
}
