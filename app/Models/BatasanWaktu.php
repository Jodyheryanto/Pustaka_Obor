<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatasanWaktu extends Model
{
    use HasFactory;
    protected $table = 'tb_batasan_waktu';
    protected $primaryKey = 'id';

    public $incrementing = true;
	public $timestamps = false;
}
