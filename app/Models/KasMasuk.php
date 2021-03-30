<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    use HasFactory;
    protected $table = 'jurnal_kas_masuk';
    protected $primaryKey = 'kode_kas_masuk';

    public $incrementing = true;
    public $timestamps = true;

    public function fakturjual()
    {
        return $this->hasOne(FakturJual::class, 'id', 'tb_faktur_penjualan_id');
    }
    public function jurnaljual()
    {
        return $this->hasOne(JurnalJual::class, 'kode_jurnal_penjualan', 'tb_jurnal_penjualan_kode');
    }
}
