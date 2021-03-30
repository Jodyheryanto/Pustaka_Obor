<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaTitip extends Model
{
    use HasFactory;
    protected $table = 'tb_penerima_titip';
    protected $primaryKey = 'id_penerima_titip';
    
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
