<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasLain2 extends Model
{
    use HasFactory;
    protected $table = 'tb_kas_lain2';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;
}
