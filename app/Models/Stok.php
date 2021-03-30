<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'tb_stock';
	protected $primaryKey = 'tb_induk_buku_kode_buku';

	public $incrementing = false;
	public $timestamps = true;
	protected $keyType = 'char';
}
