<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturKonsinyasi extends Model
{
    use HasFactory;
    protected $table = 'tb_faktur_konsinyasi';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    public function indukbuku()
    {
        return $this->hasOne(IndukBuku::class, 'kode_buku', 'tb_induk_buku_kode_buku');
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_pelanggan', 'tb_pelanggan_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id_supplier', 'tb_supplier_id');
    }
}
