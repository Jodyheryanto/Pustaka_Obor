<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use App\Models\City;

class AdminCityController extends Controller
{
    public function index(){
        $cities = City::pluck('name', 'id');
        return $cities;
    }
}
