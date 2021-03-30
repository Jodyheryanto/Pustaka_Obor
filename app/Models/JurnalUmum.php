<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_umum';
    protected $primaryKey = 'kode_jurnal_umum';

    public $incrementing = true;
    public $timestamps = true;

    public function returjual()
    {
        return $this->hasOne(ReturJual::class, 'id_retur_penjualan', 'tb_retur_penjualan_id');
    }

    public function jualbuku()
    {
        return $this->hasOne(JualBuku::class, 'id_penjualan_buku', 'tb_penjualan_buku_id');
    }

    public function belibuku()
    {
        return $this->hasOne(BeliBuku::class, 'id_pembelian_buku', 'tb_pembelian_buku_id');
    }

    public function returbeli()
    {
        return $this->hasOne(ReturBeli::class, 'id_retur_pembelian', 'tb_retur_pembelian_id');
    }
}
