<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalJual extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_penjualan';
    protected $primaryKey = 'kode_jurnal_penjualan';

    public $incrementing = true;
    public $timestamps = true;

    public function fakturjual()
    {
        return $this->hasOne(FakturJual::class, 'id', 'tb_faktur_penjualan_id');
    }

    public function kasmasuk()
    {
        return $this->hasOne(KasMasuk::class, 'tb_jurnal_penjualan_kode', 'kode_jurnal_penjualan');
    }
}
