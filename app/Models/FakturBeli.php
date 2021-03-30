<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturBeli extends Model
{
    use HasFactory;
    protected $table = 'tb_faktur_pembelian';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    public function belibuku()
    {
        return $this->hasOne(BeliBuku::class, 'id_pembelian_buku', 'tb_pembelian_buku_id');
    }

    public function jurnalbeli()
    {
        return $this->hasOne(JurnalBeli::class, 'tb_terima_bukti_id', 'id');
    }

    public function kaskeluar()
    {
        return $this->hasOne(KasKeluar::class, 'tb_terima_bukti_id', 'id');
    }
}
