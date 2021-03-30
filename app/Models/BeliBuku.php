<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class BeliBuku extends Model
{
    use HasFactory;
    protected $table = 'tb_pembelian_buku';
    protected $primaryKey = 'id_pembelian_buku';

    public $incrementing = true;
	public $timestamps = true;

    public function indukbuku()
    {
        return $this->hasOne(IndukBuku::class, 'kode_buku', 'tb_induk_buku_kode_buku');
    }
    
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id_supplier', 'tb_supplier_id');
	}

    public function returbeli()
    {
        return $this->hasOne(ReturBeli::class, 'tb_pembelian_buku_id', 'id_pembelian_buku')
            ->select(DB::raw('sum(qty) as qtyretur'));
    }

    public function returdetail()
    {
        return $this->hasMany(ReturBeli::class, 'tb_pembelian_buku_id', 'id_pembelian_buku');
    }

    public function fakturbeli()
    {
        return $this->hasOne(FakturBeli::class, 'tb_pembelian_buku_id', 'id_pembelian_buku');
    }

    public function jurnalumum()
    {
        return $this->hasOne(JurnalUmum::class, 'tb_pembelian_buku_id', 'id_pembelian_buku')->whereNotNull('debit_kredit_denda');
    }
}
