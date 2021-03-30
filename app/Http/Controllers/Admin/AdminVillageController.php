<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use App\Models\Village;

class AdminVillageController extends Controller
{
    public function index(){
        $villages = Village::pluck('name', 'id');
        return $villages;
    }
}
