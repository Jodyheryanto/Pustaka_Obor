<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Salesman extends Model
{
    use HasFactory;
    protected $table = 'tb_salesman';
	protected $primaryKey = 'id_salesman';

	public $incrementing = true;
	public $timestamps = true;

	public function jualbuku()
    {
		$request = request(); //save helper result to variable, so it can be reused
        return $this->hasOne(JualBuku::class, 'tb_salesman_id', 'id_salesman')
                ->select('tb_salesman_id', DB::raw('sum(qty) as qtyjual'), DB::raw('avg(harga_jual_satuan) as harga_satuan'), DB::raw('sum(harga_total) as harga_total'))
				->groupBy('tb_salesman_id')->where('updated_at', '>=', $request->session()->get('tgl_mulai') . " 00:00:00")->where('updated_at', '<=', date('Y-m-d', strtotime( $request->session()->get('tgl_selesai') ) ) . " 23:59:59");
		// return $this->hasMany(JualBuku::class, 'tb_salesman_id', 'id_salesman');
	}
}
