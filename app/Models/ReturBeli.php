<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBeli extends Model
{
    use HasFactory;
    protected $table = 'tb_retur_pembelian';
    protected $primaryKey = 'id_retur_pembelian';

    public function belibuku()
    {
        return $this->hasOne(BeliBuku::class, 'id_pembelian_buku', 'tb_pembelian_buku_id');
    }
}
