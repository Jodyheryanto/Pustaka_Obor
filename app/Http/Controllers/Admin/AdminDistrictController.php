<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use App\Models\District;

class AdminDistrictController extends Controller
{
    public function index(){
        $districts = District::pluck('name', 'id');
        return $districts;
    }
}
