<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'tb_histori';
	protected $primaryKey = 'id_histori';

	public $incrementing = true;
    public $timestamps = true;
    
    public function indukbuku()
    {
        return $this->hasOne(IndukBuku::class, 'kode_buku', 'tb_induk_buku_kode_buku');
    }
}
