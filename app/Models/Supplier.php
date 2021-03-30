<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'tb_supplier';
	protected $primaryKey = 'id_supplier';

	public $incrementing = true;
	public $timestamps = true;
	public function kota()
    {
        return $this->hasOne(City::class, 'id', 'tb_kota_id');
	}
	public function kecamatan()
    {
        return $this->hasOne(District::class, 'id', 'tb_kecamatan_id');
	}
	public function kelurahan()
    {
        return $this->hasOne(Village::class, 'id', 'tb_kelurahan_id');
	}

	public function belibuku()
    {
		$request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(BeliBuku::class, 'tb_supplier_id', 'id_supplier')
                ->select('tb_supplier_id', DB::raw('sum(qty) as qtybeli'), DB::raw('avg(harga_beli_satuan) as harga_satuan'), DB::raw('sum(total_harga) as harga_total'))
				->groupBy('tb_supplier_id')->where('updated_at', '>=', $request->session()->get('tgl_mulai') . " 00:00:00")->where('updated_at', '<=', date('Y-m-d', strtotime($request->session()->get('tgl_selesai') )) . " 23:59:59");
		// return $this->hasMany(JualBuku::class, 'tb_salesman_id', 'id_salesman');
	}
}
