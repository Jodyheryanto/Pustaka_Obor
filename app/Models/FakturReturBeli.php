<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturReturBeli extends Model
{
    use HasFactory;
    protected $table = 'tb_faktur_retur_pembelian';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    public function returbeli()
    {
        return $this->hasOne(ReturBeli::class, 'id_retur_pembelian', 'tb_retur_pembelian_id');
    }
}
