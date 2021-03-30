<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    use HasFactory;
    protected $table = 'jurnal_kas_keluar';
    protected $primaryKey = 'kode_kas_keluar';

    public $incrementing = true;
    public $timestamps = true;

    public function fakturbeli()
    {
        return $this->hasOne(FakturBeli::class, 'id', 'tb_terima_bukti_id');
    }
    public function jurnalbeli()
    {
        return $this->hasOne(JurnalBeli::class, 'kode_jurnal_pembelian', 'tb_jurnal_pembelian_kode');
    }
}
