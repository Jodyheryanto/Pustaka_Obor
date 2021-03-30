<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class JualBuku extends Model
{
    use HasFactory;
    protected $table = 'tb_penjualan_buku';
    protected $primaryKey = 'id_penjualan_buku';

    public $incrementing = true;
    public $timestamps = true;
    
    public function indukbuku()
    {
        return $this->hasOne(IndukBuku::class, 'kode_buku', 'tb_induk_buku_kode_buku');
    }

    public function salesman()
    {
        return $this->hasOne(Salesman::class, 'id_salesman', 'tb_salesman_id');
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_pelanggan', 'tb_pelanggan_id');
    }

    public function histori()
    {
        return $this->hasOne(Histori::class, 'tb_penjualan_buku_id', 'id_penjualan_buku');
    }

    public function fakturjual()
    {
        return $this->hasOne(FakturJual::class, 'tb_penjualan_buku_id', 'id_penjualan_buku');
    }

    public function jurnaljual()
    {
        return $this->hasOne(JurnalJual::class, 'tb_penjualan_buku_id', 'id_penjualan_buku');
    }

    public function jurnalumum()
    {
        return $this->hasOne(JurnalUmum::class, 'tb_penjualan_buku_id', 'id_penjualan_buku')->whereNotNull('debit_kredit_denda');
    }

    public function returjual()
    {
        return $this->hasOne(ReturJual::class, 'tb_penjualan_buku_id', 'id_penjualan_buku')
            ->select(DB::raw('sum(total_harga) as total_harga'), DB::raw('sum(qty) as qtyretur'), DB::raw('sum(total_non_diskon) as total_non_diskon'));
    }

    public function returdetail()
    {
        return $this->hasMany(ReturJual::class, 'tb_penjualan_buku_id', 'id_penjualan_buku');
    }

    public function returroyalti()
    {
        return $this->hasOne(ReturJual::class, 'tb_penjualan_buku_id', 'id_penjualan_buku')
            ->select(DB::raw('sum(total_non_diskon) as total_non_diskon'), DB::raw('sum(qty) as qtyretur'));
    }
}
