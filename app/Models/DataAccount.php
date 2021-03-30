<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAccount extends Model
{
    use HasFactory;
    protected $table = 'tb_data_account';
    protected $primaryKey = 'id_account';

    public $incrementing = false;
    protected $keyType = 'char';
	public $timestamps = true;
}
