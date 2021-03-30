<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturJual extends Model
{
    use HasFactory;
    protected $table = 'tb_retur_penjualan';
    protected $primaryKey = 'id_retur_penjualan';

    public function jualbuku()
    {
        return $this->hasOne(JualBuku::class, 'id_penjualan_buku', 'tb_penjualan_buku_id');
    }
}
