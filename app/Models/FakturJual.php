<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturJual extends Model
{
    use HasFactory;
    protected $table = 'tb_faktur_penjualan';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    public function jualbuku()
    {
        return $this->hasOne(JualBuku::class, 'id_penjualan_buku', 'tb_penjualan_buku_id');
    }

    public function jurnaljual()
    {
        return $this->hasOne(JurnalJual::class, 'tb_faktur_penjualan_id', 'id');
    }

    public function kasmasuk()
    {
        return $this->hasOne(KasMasuk::class, 'tb_faktur_penjualan_id', 'id');
    }
}
