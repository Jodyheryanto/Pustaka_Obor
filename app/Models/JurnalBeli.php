<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalBeli extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_pembelian';
    protected $primaryKey = 'kode_jurnal_pembelian';

    public $incrementing = true;
    public $timestamps = true;

    public function fakturbeli()
    {
        return $this->hasOne(FakturBeli::class, 'id', 'tb_terima_bukti_id');
    }

    public function kaskeluar()
    {
        return $this->hasOne(KasKeluar::class, 'tb_jurnal_pembelian_kode', 'kode_jurnal_pembelian');
    }
}
