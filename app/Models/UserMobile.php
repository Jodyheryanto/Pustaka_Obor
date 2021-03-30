<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMobile extends Model
{
    use HasFactory;
    protected $table = 'tb_user_mobile';
	protected $primaryKey = 'id_user_mobile';

	public $incrementing = true;
	public $timestamps = true;
}
