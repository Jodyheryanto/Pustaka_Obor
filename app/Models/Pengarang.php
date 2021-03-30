<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    use HasFactory;
    protected $table = 'tb_pengarang';
	protected $primaryKey = 'id_pengarang';

	public $incrementing = true;
	public $timestamps = true;
	public function negara()
    {
        return $this->hasOne(Country::class, 'id', 'tb_negara_id');
	}
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
	public function indukbuku()
    {
        return $this->hasMany(IndukBuku::class, 'tb_pengarang_id', 'id_pengarang');
	}
}
