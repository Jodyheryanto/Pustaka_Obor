<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'tb_lokasi';
	protected $primaryKey = 'id_lokasi';

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
}
