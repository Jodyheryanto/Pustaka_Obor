<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use App\Models\Country;

class AdminCountryController extends Controller
{
    public function index(){
        $countries = Country::pluck('name', 'id');
        return $countries;
    }
}
