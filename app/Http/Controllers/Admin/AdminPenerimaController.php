<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\PenerimaTitip;

class AdminPenerimaController extends Controller
{
    public function getInfo($id)
    {
        $fill = PenerimaTitip::with(['kota', 'kecamatan', 'kelurahan'])->where('id_penerima_titip', $id)->first();
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}
