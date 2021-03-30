<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturReturJual extends Model
{
    use HasFactory;
    protected $table = 'tb_faktur_retur_penjualan';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    public function returjual()
    {
        return $this->hasOne(ReturJual::class, 'id_retur_penjualan', 'tb_retur_penjualan_id');
    }
}
